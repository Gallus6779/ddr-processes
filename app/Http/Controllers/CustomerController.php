<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    // public function index(Request $request): View | JsonResponse
    {
        validate_permission('customers.read');
        validate_permission('customers.discounts.read');

        // if ($request->ajax()) {
        //     $rows = Permission::offset($request->start)->limit($request->length);
        //     $totalRecords = Permission::count();

        //     return DataTables::of($rows)
        //         ->setTotalRecords($totalRecords)
        //         ->setFilteredRecords($totalRecords)
        //         ->addColumn('actions', function ($row) {
        //             return Blade::render('
        //                 <div class="btn-group">
        //                     @permission(\'permissions.update\')
        //                         @onlydev
        //                             <a href="{{ route(\'admin.permissions.edit\', $row) }}" class="btn btn-default">Update</a>
        //                         @endonlydev
        //                     @endpermission
        //                     @permission(\'permissions.delete\')
        //                         @onlydev
        //                             <button type="button" class="btn btn-danger delete-btn" data-destroy="{{ route(\'admin.permissions.destroy\', $row) }}">Delete</button>
        //                         @endonlydev
        //                     @endpermission
        //                 </div>
        //             ', ['row' => $row->id]);
        //         })
        //         ->addColumn('updated_at', function ($row) {
        //             return Blade::render('
        //                 {{ $row->updated_at->format(\'M d, Y\') }}
        //             ', ['row' => $row]);
        //         })
        //         ->rawColumns(['actions', 'updated_at'])
        //         ->make(true);
        // }

        // $tableConfigs = (new DataTablesColumnsBuilder(Permission::class))
        //     ->setSearchable('name')
        //     ->setOrderable('name')
        //     ->setName('updated_at', 'Updated at')
        //     ->removeColumns(['created_at'])
        //     ->withActions()
        //     ->make();

        // return view('admin.customers.discounts', compact('tableConfigs'));
        return view('admin.customers.discounts');
    }

    /**
     * 
     */
    public function consumptions(){
        return view('admin.customers.consumptions');
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
