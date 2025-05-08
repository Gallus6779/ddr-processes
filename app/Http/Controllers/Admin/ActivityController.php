<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Affiche la liste des activités journalisées
     */
    public function index(Request $request)
    {
        // Validation des permissions
        try {
            validate_permission('admin.activities.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'avez pas la permission de consulter les journaux d\'activité.']);
        }

        // Préparer les filtres
        $logName = $request->input('log_name');
        $userId = $request->input('user_id');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        try {
            // Vérifier la configuration de la table
            $tableName = config('activitylog.table_name', 'activity_log');

            // Construire la requête avec les filtres - utiliser directement le modèle d'activité de Spatie
            $query = \Spatie\Activitylog\Models\Activity::with(['causer', 'subject'])->latest();

            if ($logName) {
                $query->where('log_name', $logName);
            }

            if ($userId) {
                $query->where('causer_id', $userId);
            }

            if ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            }

            if ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            }

            // Récupérer les activités paginées
            $activities = $query->paginate(15);

            // Récupérer les valeurs distinctes pour les filtres
            $logNames = \Spatie\Activitylog\Models\Activity::distinct('log_name')->pluck('log_name');

            // Récupérer l'utilisateur connecté
            $user = $request->user();

            return view('admin.activities.index', compact('activities', 'logNames', 'user', 'logName', 'userId', 'dateFrom', 'dateTo', 'tableName'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des activités: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération des activités: ' . $e->getMessage()]);
        }
    }

    /**
     * Affiche les détails d'une activité spécifique
     */
    public function show($id)
    {
        // Validation des permissions
        try {
            validate_permission('admin.activities.read');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'avez pas la permission de consulter les journaux d\'activité.']);
        }

        $activity = Activity::with(['causer', 'subject'])->findOrFail($id);
        $user = request()->user();

        return view('admin.activities.show', compact('activity', 'user'));
    }

    /**
     * Supprime un journal d'activité
     */
    public function destroy($id)
    {
        // Validation des permissions
        try {
            validate_permission('admin.activities.delete');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'avez pas la permission de supprimer les journaux d\'activité.']);
        }

        $activity = Activity::findOrFail($id);
        $activity->delete();

        // Enregistrer cette action de suppression
        activity()
            ->causedBy(request()->user())
            ->withProperties(['deleted_activity_id' => $id])
            ->log('Suppression d\'un journal d\'activité');

        return redirect()->route('admin.activities.index')->with('success', 'Le journal d\'activité a été supprimé avec succès.');
    }

    /**
     * Vider les journaux d'activité (avec confirmation)
     */
    public function clear(Request $request)
    {
        // Validation des permissions
        try {
            validate_permission('admin.activities.delete');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'avez pas la permission de supprimer les journaux d\'activité.']);
        }

        // Vérifier la confirmation
        if (!$request->has('confirm') || $request->input('confirm') !== 'true') {
            return redirect()->route('admin.activities.index')->withErrors(['error' => 'Vous devez confirmer la suppression de tous les journaux d\'activité.']);
        }

        // Enregistrer cette action avant de supprimer
        activity()
            ->causedBy($request->user())
            ->log('Suppression de tous les journaux d\'activité');

        // Supprimer toutes les activités
        Activity::truncate();

        return redirect()->route('admin.activities.index')->with('success', 'Tous les journaux d\'activité ont été supprimés avec succès.');
    }
}
