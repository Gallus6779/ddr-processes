<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Discount;
use App\Models\DiscountPeriod;
use App\Models\Customer;
use App\Models\Card;
use App\Models\CustomerType;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * 
     */
    public function discount_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée
        
        // Validate permission
        try {
            validate_permission('discounts.read');
            validate_permission('discounts.discounts.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        // Fetch districts with related models
        try {
            $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $discount_periods = DiscountPeriod::get();
            $districts = District::get();

            return view('admin.discounts.discounts', compact('discounts', 'discount_periods', 'districts', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        }
    }

    /**
     * 
     */
    public function discount_periods_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée

        // Validate permission
        try {
            validate_permission('discounts.discount_periods.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }
        
        // Fetch districts with related models
        // try {
            // dd(1);
            $discount_periods = DiscountPeriod::latest()->with('createdBy', 'validatedBy')->paginate(10);
            // dd(1);
            $districts = District::get();
            
            return view('admin.discounts.periods', compact('discount_periods', 'districts', 'user'));
        // } catch (\Exception $e) {
        //     return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        // }
    }

    /**
     * 
     */
    public function discount_create(Request $request){
        validate_permission('discounts.discounts.create');

        dd($request);
    }
    /**
     * 
     */
    public function consumptions(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée

        return view('admin.discounts.consumptions', compact('user'));

    }

    /**
     * 
     */
    public function beneficiary_discount_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée
        
        // Validate permission
        try {
            validate_permission('discounts.read');
            validate_permission('discounts.discounts.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        // Fetch districts with related models
        try {
            $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $discount_periods = DiscountPeriod::get();
            $districts = District::get();

            return view('admin.discounts.beneficiary', compact('discounts', 'discount_periods', 'districts', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        }
    }

    /**
     * 
     */
    public function customers_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée
        
        // Validate permission
        try {
            validate_permission('discounts.read');
            validate_permission('discounts.customers.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view customers.']);
        }

        // Fetch districts with related models
        try {
            $customers = Customer::get();
            $customer_types = CustomerType::get();

            return view('admin.discounts.customers', compact('customers', 'customer_types', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        }
    }
    
    
    /**
     * 
     */
    public function customers_create(Request $request){

        try {        
            validate_permission('discounts.customers.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to create customer.']);
        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|unique:customers',
            'customer_type_id' => 'required|exists:customer_types,id',
            'number' => 'required|numeric|unique:cards',
            'card_owner' => 'required|string',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'required|numeric'
        ],[
            'name.required' => 'Name field is required.',
            'customer_type_id.required' => 'Customer Type field is required.',
            'name.unique' => 'Name field is already taken.',
            'email.unique' => 'Email field is already taken.',
            'customer_type_id.required' => 'Customer Type field doesn\'t exist.'
        ]);

        $customer_data = $request->except(['number', 'card_owner']);

        DB::transaction(function () use ($request, $customer_data) {
            $customer = Customer::create($customer_data);

            $card = new Card();

            $card->number = $request->number;
            $card->card_owner = $request->card_owner;
            $card->customer_id = $customer->id;

            $card->save();
        });
        
        
        return back()->with('success', 'Customer created successfully.');
    }

    /**
     * 
     */
    public function customers_update(Customer $customer, Card $card, Request $request){

        try {        
            validate_permission('discounts.customers.update');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to update customer.']);
        }
        dump($card);
        dd($customer);
        $validatedData = $request->validate([
            'name' => 'required|string|unique:customers',
            'customer_type_id' => 'required|exists:customer_types,id',
            'number' => 'required|numeric|unique:cards',
            'card_owner' => 'required|string',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'required|numeric'
        ],[
            'name.required' => 'Name field is required.',
            'customer_type_id.required' => 'Customer Type field is required.',
            'name.unique' => 'Name field is already taken.',
            'email.unique' => 'Email field is already taken.',
            'customer_type_id.required' => 'Customer Type field doesn\'t exist.'
        ]);

        $customer_data = $request->except(['number', 'card_owner']);

        $card = Card::where();

        $card->number = $request->number;
        $card->card_owner = $request->card_owner;
        $card->customer_id = $customer->id;

        $card->save();
        DB::transaction(function () use ($request, $customer) {
            $customer->update($request->except(['number', 'card_owner']));

            
        });

        return back()
            ->with('success', 'Customer has been updated successfully.');
        
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
