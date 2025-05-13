<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Product;
use App\Models\Sales;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'stations' => Station::paginate(10),
            'products' => Product::paginate(10),
            'sales' => Sales::with('station')->paginate(10)
            
                
        ];
        return view('admin.sales.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'station_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'sale_date' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            'station_id.required' => 'Station field is required.',
            'product_id.required' => 'Product field is required.',
            'quantity.required' => 'Quantity field is required.'
        ]);

        // $user_id = auth()->user()->id;
        // $validatedData += [
        //     "created_by" => $user_id, 
        //     "validated_by" => $user_id
        // ];
        
        $sales = Sales::create($validatedData);
        // dd($sales);

        return back()->with('success', 'District created successfully.');
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
