<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Imports\ImportCustomerList;
use Maatwebsite\Excel\Facades\Excel;

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

        if($request->has('filename')){

            $customerImport = new ImportCustomerList();
            // dump($_FILES['filename']['tmp_name']);

            // dump($customerImport->import($request->file('filename')));
            $response = $customerImport->import($_FILES['filename']);
            // dump($customerImport->import($_FILES['filename']));

            
            // Decode the JsonResponse data
            $responseData = $response->getData(true);
            
            // dd($responseData['error']);

            if(isset($responseData['error'])){
                return redirect()->back()->withErrors($responseData);
            }


            return back()->with($responseData['success']);
            // Access the data
            // $message = $responseData['message'];
            // $data = $responseData['data'];
            // dd($data);
            // dd($result->message);
            // dump($customerImport->errors());
            // dd($request->file('filename'));

        }else{
            $customer = Customer::where('name', $request->name)->first();
        
            if(empty($customer)){
    
                $validatedData = $request->validate([
                    'name' => ['required','string', 'unique:customers,name'],
                    'customer_type_id' => 'required|exists:customer_types,id',
                    'number' => 'required|numeric|unique:cards',
                    'card_owner' => 'required|string',
                    'email' => 'required|email|unique:customers',
                    'phone' => 'required|numeric'
                ],[
                    'name.required' => 'Name field is required.',
                    'name.unique' => 'Name field is already taken.',
                    'email.unique' => 'Email field is already taken.',
                    'customer_type_id.required' => 'Customer Type field doesn\'t exist.',
    
                    'card_owner.required' => 'cardOwner field is required.',
                    'number.required' => 'Number field is required.',
                    'phone.required' => 'Phone field is required.',
                    'email.required' => 'Email field is required.'
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
    
            }else{
                $validatedData = $request->validate([
                    'name' => ['required','string'],
                    'customer_type_id' => 'required|exists:customer_types,id',
                    'number' => 'required|numeric|unique:cards',
                    'card_owner' => 'required|string'
                ],[
                    'name.required' => 'Name field is required.',
                    'card_owner.required' => 'cardOwner field is required.',
                    'number.required' => 'Number field is required.',
                    'phone.required' => 'Phone field is required.',
                    
                    'customer_type_id.required' => 'Customer Type field doesn\'t exist.'
                ]);
    
                // $customer_data = $request->except(['number', 'card_owner']);
        
                // DB::transaction(function () use ($request, $customer_data) {
                DB::transaction(function () use ($request, $customer) {
                    // $customer = Customer::create($customer_data);
        
                    $card = new Card();
        
                    $card->number = $request->number;
                    $card->card_owner = $request->card_owner;
                    $card->customer_id = $customer->id;
        
                    $card->save();
                });
                return back()->with('success', 'Customer ' . $customer->name . ' card has been added successfully.');
            }
        }

        
        
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
        
        $validatedData = $request->validate([
            'name' => ['required', 'string', Rule::unique('customers')->ignore($customer->id)],
            'customer_type_id' => 'required|exists:customer_types,id',
            'number' => ['required', 'numeric', Rule::unique('cards')->ignore($card->id)],
            'card_owner' => 'required|string',
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'phone' => 'required|numeric' 
        ],[
            'name.required' => 'Name field is required.',
            'customer_type_id.required' => 'Customer Type field is required.',
            'name.unique' => 'Name field is already taken.',
            'email.unique' => 'Email field is already taken.',
            'customer_type_id.required' => 'Customer Type field doesn\'t exist.'
        ]); 

        $customer_data = $request->except(['number', 'card_owner']);

        $card_data = $request->only(['number', 'card_owner']);

        DB::transaction(function () use ($request, $customer, $card, $customer_data, $card_data ) {
            $customer->update($customer_data);
            $card->update($card_data);
        });

        return back()->with('success', 'Customer has been updated successfully.');        
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
