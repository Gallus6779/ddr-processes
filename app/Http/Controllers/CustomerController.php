<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\District;
use App\Models\Discount;
use App\Models\DiscountPeriod;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.customers.index');
    }

    /**
     * Display discounts.
     */
    public function discount_read(Request $request)
    {
        $user = $request->user();

        // Validate permissions
        try {
            validate_permission('customers.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view customers.']);
        }

        try {
            validate_permission('discounts.discounts.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view discounts.']);
        }

        // Fetch data
        try {
            $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $discount_periods = DiscountPeriod::get();
            $districts = District::get();

            activity()
                ->causedBy($request->user())
                ->withProperties(['count' => $discounts->total()])
                ->log('Consultation de la liste des remises');

            return view('admin.discounts.index', compact('discounts', 'discount_periods', 'districts', 'user'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des remises: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error fetching discounts or related data from the database.']);
        }
    }

    /**
     * Display consumptions.
     */
    public function consumptions(Request $request)
    {
        $user = $request->user();

        activity()
            ->causedBy($request->user())
            ->log('Consultation des consommations');

        return view('admin.discounts.consumptions', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'customer_type_id' => 'required|exists:customer_types,id'
        ]);

        $customer = Customer::create($validated);

        activity()
            ->causedBy($request->user())
            ->performedOn($customer)
            ->withProperties([
                'firstname' => $customer->firstname,
                'lastname' => $customer->lastname,
                'type_id' => $customer->customer_type_id
            ])
            ->log('Création d\'un client');

        return redirect()->back()->with('success', 'Client créé avec succès');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'customer_type_id' => 'required|exists:customer_types,id'
        ]);

        $oldValues = [
            'firstname' => $customer->firstname,
            'lastname' => $customer->lastname,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'customer_type_id' => $customer->customer_type_id
        ];

        $customer->update($validated);

        activity()
            ->causedBy($request->user())
            ->performedOn($customer)
            ->withProperties([
                'old_values' => $oldValues,
                'new_values' => $validated
            ])
            ->log('Mise à jour d\'un client');

        return redirect()->back()->with('success', 'Client mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($customer)
                ->withProperties([
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname
                ])
                ->log('Suppression d\'un client');

            $customer->delete();
            return redirect()->back()->with('success', 'Client supprimé avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible de supprimer ce client : ' . $e->getMessage());
        }
    }
}
