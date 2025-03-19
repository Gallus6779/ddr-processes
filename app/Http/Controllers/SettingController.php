<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Station;
use App\Models\District;
use App\Models\Discount;
use App\Models\DiscountPeriod;

class SettingController extends Controller
{
    /**
     * 
     */
    public function station_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée
        
        // Validate permission
        try {
            validate_permission('settings.stations.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        // Fetch districts with related models
        try {
            $stations = Station::latest()->with('createdBy', 'validatedBy')->paginate(10);
            $districts = District::get();

            return view('admin.station-services.index', compact('stations','districts','user'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        }

    }

    /**
     * 
     */
    public function stations_create(Request $request){

        // Validate permission
        try {        
            validate_permission('settings.stations.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        $validatedData = $request->validate([
            'name' => 'required|unique:stations',
            'district_id' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'district_id.required' => 'District field is required.',

            'name.unique' => 'Name field is already used.'
        ]);

        $user_id = auth()->user()->id;
        $validatedData += [
            "created_by" => $user_id, 
            "validated_by" => $user_id
        ];
        
        $station = Station::create($validatedData);
        // dd($district);

        return back()->with('success', 'District created successfully.');
    }

    public function stations_update(Request $request, $id){
        
        $station = Station::findOrFail($id);

        // Validate permission
        try {        
            validate_permission('settings.stations.update');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }
        
        $validatedData = $request->validate([
            'name' => ['required',  Rule::unique('stations')->ignore($station->id)],
            'district_id' => ['required'],
        ], [
            'name.required' => 'Name field is required.',
            'district_id.required' => 'District field is required.',

            'name.unique' => 'Name field is already used.'
        ]);

        $user_id = auth()->user()->id;
        $validatedData += [ 
            "validated_by" => $user_id
        ];
        
        $station->update($validatedData);
        // dd($district);
        return back()->with('success', 'Station updated successfully.');
    }

    /**
     * 
     */
    // public function discount_read(Request $request){

    //     $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée
        
    //     // Validate permission
    //     try {
    //         validate_permission('discounts.read');
    //         validate_permission('discounts.discounts.read');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
    //     }

    //     // Fetch districts with related models
    //     // try {
    //         $discounts = Discount::latest()->with('createdBy', 'validatedBy')->paginate(10);
    //         $discount_periods = DiscountPeriod::get();
    //         $districts = District::get();

    //         return view('admin.discounts.discounts', compact('discounts', 'discount_periods', 'districts', 'user'));
    //     // } catch (\Exception $e) {
    //     //     return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
    //     // }
    // }

    // /**
    //  * 
    //  */
    // public function discount_periods_read(Request $request){

    //     $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée

    //     // Validate permission
    //     try {
    //         validate_permission('discounts.discount_periods.read');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
    //     }
        
    //     // Fetch districts with related models
    //     // try {
    //         // dd(1);
    //         $discount_periods = DiscountPeriod::latest()->with('createdBy', 'validatedBy')->paginate(10);
    //         // dd(1);
    //         $districts = District::get();
            
    //         return view('admin.discounts.periods', compact('discount_periods', 'districts', 'user'));
    //     // } catch (\Exception $e) {
    //     //     return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
    //     // }
    // }

    /**
     * 
     */
    public function discount_periods_create(Request $request){

        // Validate permission
        try {
            validate_permission('discounts.discount_periods.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        $validatedData = $request->validate([
            'name' => 'required|unique:discount_periods',
            'district_id' => [
                'required',
                // 'unique:discount_periods,district_id,NULL,id,start_date,<=,' . $request->start_date . ',end_date,>=,' . $request->end_date,
            ],
            'start_date' => [
                'required',
            ],
            'end_date' => 'required|date|after:start_date'
        ], [
            'name.required' => 'Name field is required.',
            'district_id.required' => 'District field is required.',
            'start_date.required' => 'Start date field is required.',
            'end_date.required' => 'End date field is required.',
            'end_date.after' => 'End date field should be after start date.'
        ]);

        if($request->description){
            $validatedData += [
                "description" => $request->description,
            ];
        }
        
        $user_id = auth()->user()->id;
        $validatedData += [
            "created_by" => $user_id, 
            "validated_by" => $user_id
        ];
        
        // dd($validatedData);
        // Store districts with related models
        try {
            $discount_period = DiscountPeriod::create($validatedData);
            return back()->with('success', 'Discount created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error storing discounts from the database.']);
        }

    }

    /**
     * 
     */
    public function discount_periods_update(Request $request, $id){
    
        $discount_period = DiscountPeriod::findOrFail($id);

        // Validate permission
        try {        
            validate_permission('discounts.discount_periods.update');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }
        
        $validatedData = $request->validate([
            'name' => 'required|unique:discount_periods',
            'district_id' => [
                'required',
                // 'unique:discount_periods,district_id,NULL,id,start_date,<=' . $request->start_date . ',end_date,>=' . $request->end_date,
            ],
            'start_date' => [
                'required',
            ],
            'end_date' => 'required|date|after:start_date'
        ], [
            'name.required' => 'Name field is required.',
            'district_id.required' => 'District field is required.',
            'start_date.required' => 'Start date field is required.',
            'end_date.required' => 'End date field is required.',
            'end_date.after' => 'End date field should be after start date.'
        ]);

        if($request->description){
            $validatedData += [
                "description" => $request->description,
            ];
        }

        // $user_id = auth()->user()->id;
        // $validatedData += [ 
        //     "updated_by" => $user_id
        // ];
        
        $discount_period->update($validatedData);
        // dd($district);
        return back()->with('success', 'District updated successfully.');
    }

    // /**
    //  * 
    //  */
    // public function settings_discounts_create(Request $request){
    //     validate_permission('discounts.discounts.create');

    //     dd($request);
    // }

    /**
     * 
     */
    public function districts_read(Request $request){

        $user = $request->user();  // chargement des parametres de l'utilisateur connecté dans la vue appelée

        // Validate permission
        try {
            validate_permission('settings.districts.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }

        // Fetch districts with related models
        try {
            $districts = District::latest()->with('createdBy', 'validatedBy')->paginate(10);

            // dd($districts);
            return view('admin.districts.index', compact('districts', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error fetching districts from the database.']);
        }
    }

    /**
     * 
     */
    public function districts_create(Request $request){

        // dd(validate_permission('settings.stations.create'));
        validate_permission('settings.districts.create');

        $validatedData = $request->validate([
            'name' => 'required|unique:districts',
            'acronym' => 'required|unique:districts'
        ], [
            'name.required' => 'Name field is required.',
            'acronym.required' => 'Acronym field is required.',

            'name.unique' => 'Name field is already used.',
            'acronym.unique' => 'Acronym field is already used.'
        ]);

        $user_id = auth()->user()->id;
        $validatedData += [
            "created_by" => $user_id, 
            "validated_by" => $user_id
        ];
        
        $district = District::create($validatedData);
        // dd($district);

        return back()->with('success', 'District created successfully.');
    }

    public function districts_update(Request $request, $id){
        
        $district = District::findOrFail($id);

        // Validate permission
        try {        
            validate_permission('settings.districts.update');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to view districts.']);
        }
        
        $validatedData = $request->validate([
            'name' => ['required',  Rule::unique('districts')->ignore($district->id)],
            'acronym' => ['required', Rule::unique('districts')->ignore($district->id)],
        ], [
            'name.required' => 'Name field is required.',
            'acronym.required' => 'Acronym field is required.',

            'name.unique' => 'Name field is already used.',
            'acronym.unique' => 'Acronym field is already used.'
        ]);

        $user_id = auth()->user()->id;
        $validatedData += [ 
            "validated_by" => $user_id
        ];
        
        $district->update($validatedData);
        // dd($district);
        return back()->with('success', 'District updated successfully.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
