<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consumption;
use App\Imports\ConsumptionsImport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ConsumptionController extends Controller
{
    public function index(): View
    {
        validate_permission('consumptions.read');

        try {
            $consumptions = Consumption::with(['customer', 'card.station'])
                ->latest('date_consumption')
                ->paginate(15);

            return view('admin.discounts.consumptions', compact('consumptions'));
        } catch (\Exception $e) {
            return view('admin.discounts.consumptions', [
                'consumptions' => collect(),
                'error' => 'Une erreur est survenue lors du chargement des données.'
            ]);
        }
    }

    public function import(Request $request)
    {
        // validate_permission('consumptions.create');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new ConsumptionsImport;
            Excel::import($import, $request->file('file'));

            if (count($import->getErrors()) > 0) {
                return redirect()
                    ->route('admin.consumptions.index')
                    ->with('error', implode('<br>', $import->getErrors()));
            }

            return redirect()
                ->route('admin.consumptions.index')
                ->with('success', 'Consumptions imported successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.consumptions.index')
                ->with('error', 'Error importing consumptions: ' . $e->getMessage());
        }
    }
}
