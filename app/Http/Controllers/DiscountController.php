<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\District;
use App\Models\Discount;
use App\Models\DiscountPeriod;
use App\Models\Consumption;
// Importer le façade d'activité
use Spatie\Activitylog\Facades\LogBatch;

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

        $consumptions = Consumption::with(['customer', 'card.station'])
            ->orderBy('date_consumption', 'desc')
            ->paginate(10);

        return view('admin.discounts.consumptions', compact('user', 'consumptions'));

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
     * Calcule une ristourne pour une consommation donnée
     */
    public function calculateDiscount(Request $request)
    {
        // Validation des permissions
        try {
            validate_permission('discounts.discounts.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'avez pas la permission de créer des ristournes.']);
        }

        // Validation des données
        $request->validate([
            'consumption_id' => 'required|exists:consumptions,id',
            'period_discount_id' => 'required|exists:discount_periods,id' // Ajouter cette validation
        ]);

        try {
            $consumption = Consumption::with('customer', 'card')->findOrFail($request->consumption_id);

            // Vérifier si une ristourne existe déjà pour cette consommation
            $existingDiscount = Discount::where('consumption_id', $consumption->id)->first();
            if ($existingDiscount) {
                return redirect()->back()->withErrors(['error' => 'Une ristourne existe déjà pour cette consommation.']);
            }

            // Vérifier que la carte existe
            if (!$consumption->card_id) {
                return redirect()->back()->withErrors(['error' => 'Cette consommation n\'est pas associée à une carte. Impossible de créer une ristourne.']);
            }

            // Calcul de la ristourne (5 FCFA par litre)
            $discountAmount = $consumption->quantity * 5;

            // Création de la ristourne
            $discount = new Discount();
            $discount->customer_id = $consumption->customer_id;
            $discount->consumption_id = $consumption->id;
            $discount->card_id = $consumption->card_id;
            $discount->period_discount_id = $request->period_discount_id; // Ajouter cette ligne
            $discount->amount = $discountAmount;
            $discount->status = 'pending';
            $discount->created_by = $request->user()->id;
            $discount->save();

            // Journalisation de l'activité
            activity()
                ->causedBy($request->user())
                ->performedOn($discount)
                ->withProperties([
                    'montant' => $discountAmount,
                    'customer_id' => $consumption->customer_id,
                    'consumption_id' => $consumption->id,
                    'volume' => $consumption->quantity
                ])
                ->log('Création d\'une ristourne');

            return redirect()->back()->with('success', "Une ristourne de {$discountAmount} FCFA a été créée avec succès.");
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur de calcul de ristourne: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Une erreur s\'est produite lors du calcul de la ristourne: ' . $e->getMessage()]);
        }
    }

    /**
     * Calcule les ristournes pour toutes les consommations sans ristourne
     */
    public function calculateAllDiscounts(Request $request)
    {
        // Validation des permissions
        try {
            validate_permission('discounts.discounts.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'avez pas la permission de créer des ristournes.']);
        }

        // Validation des données
        $request->validate([
            'period_discount_id' => 'required|exists:discount_periods,id' // Ajouter cette validation
        ]);

        try {
            // Démarrer un batch d'activité
            LogBatch::startBatch();

            // Récupérer les consommations sans ristourne qui ont une carte associée
            $consumptions = Consumption::whereDoesntHave('discount')
                ->whereNotNull('card_id')
                ->with('customer', 'card')
                ->get();

            $count = 0;
            $totalAmount = 0;

            foreach ($consumptions as $consumption) {
                // Calcul de la ristourne (5 FCFA par litre)
                $discountAmount = $consumption->quantity * 5;

                // Création de la ristourne
                $discount = new Discount();
                $discount->customer_id = $consumption->customer_id;
                $discount->consumption_id = $consumption->id;
                $discount->card_id = $consumption->card_id;
                $discount->period_discount_id = $request->period_discount_id; // Ajouter cette ligne
                $discount->amount = $discountAmount;
                $discount->status = 'pending';
                $discount->created_by = $request->user()->id;
                $discount->save();

                // Journalisation de l'activité
                activity()
                    ->causedBy($request->user())
                    ->performedOn($discount)
                    ->withProperties([
                        'montant' => $discountAmount,
                        'customer_id' => $consumption->customer_id,
                        'consumption_id' => $consumption->id,
                        'volume' => $consumption->quantity
                    ])
                    ->log('Création d\'une ristourne en traitement par lot');

                $count++;
                $totalAmount += $discountAmount;
            }

            // Terminer le batch d'activité
            LogBatch::endBatch();

            // Journaliser l'activité globale
            if ($count > 0) {
                activity()
                    ->causedBy($request->user())
                    ->withProperties([
                        'nombre_ristournes' => $count,
                        'montant_total' => $totalAmount,
                        'periode_id' => $request->period_discount_id
                    ])
                    ->log('Calcul de ' . $count . ' ristournes pour un total de ' . $totalAmount . ' FCFA');

                return redirect()->back()->with('success', "{$count} ristournes calculées pour un total de {$totalAmount} FCFA.");
            } else {
                return redirect()->back()->withErrors(['error' => 'Aucune consommation éligible pour le calcul de ristourne.']);
            }
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            Log::error('Erreur de calcul de ristourne: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Une erreur s\'est produite lors du calcul des ristournes: ' . $e->getMessage()]);
        }
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
