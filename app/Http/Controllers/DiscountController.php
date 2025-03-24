<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Discount;
use App\Models\DiscountPeriod;

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
        // try {
            $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $discount_periods = DiscountPeriod::get();
            $districts = District::get();

            return view('admin.discounts.discounts', compact('discounts', 'discount_periods', 'districts', 'user'));
        // } catch (\Exception $e) {
        //     return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        // }
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
        // try {
            $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $discount_periods = DiscountPeriod::get();
            $districts = District::get();

            return view('admin.discounts.beneficiary', compact('discounts', 'discount_periods', 'districts', 'user'));
        // } catch (\Exception $e) {
        //     return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        // }
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
