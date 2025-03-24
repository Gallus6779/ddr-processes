<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index(): View
    {
        validate_permission('imports.read');
        return view('admin.imports.index');
    }

    public function store(Request $request)
    {
        validate_permission('imports.create');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));

            return redirect()
                ->route('admin.imports.index')
                ->with('success', 'Users imported successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.imports.index')
                ->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }

    public function storeCustomers(Request $request)
    {
        validate_permission('imports.create');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new CustomersImport;
            Excel::import($import, $request->file('file'));

            if (count($import->getErrors()) > 0) {
                return redirect()
                    ->route('admin.imports.index')
                    ->with('error', implode('<br>', $import->getErrors()));
            }

            return redirect()
                ->route('admin.imports.index')
                ->with('success', 'Customers imported successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.imports.index')
                ->with('error', 'Error importing customers: ' . $e->getMessage());
        }
    }
}
