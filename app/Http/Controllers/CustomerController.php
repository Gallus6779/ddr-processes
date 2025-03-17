<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Discount;
use App\Models\DiscountPeriod;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    // public function index(Request $request): View | JsonResponse
    {
        // validate_permission('customers.discounts.read');
        
        // return view('admin.customers.discounts');
    }
    
    /**
     * 
     */
    public function discount_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée
        
        // Validate permission
        try {
            validate_permission('customers.read');
            validate_permission('settings.discounts.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        // Fetch districts with related models
        // try {
            $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $discount_periods = DiscountPeriod::get();
            $districts = District::get();

            return view('admin.discounts.index', compact('discounts', 'discount_periods', 'districts', 'user'));
        // } catch (\Exception $e) {
        //     return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        // }
    }

    /**
     * 
     */
    public function consumptions(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée

        return view('admin.customers.consumptions', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
