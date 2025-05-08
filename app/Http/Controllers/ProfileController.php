<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        validate_permission('profile.read');
        $user = $request->user();

        // Journalisation
        activity()
            ->causedBy($user)
            ->log('Consultation du profil');

        return view('profile.index', compact('user'));
    }

    public function edit(Request $request): View
    {
        validate_permission('profile.update');
        $user = $request->user();

        // Journalisation
        activity()
            ->causedBy($user)
            ->log('Édition du profil');

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        validate_permission('profile.update');

        $user = $request->user();

        // Sauvegarder les anciennes valeurs pour le log
        $oldValues = [
            'name' => $user->name,
            'email' => $user->email
        ];

        $user->fill($request->validated());
        $user->save();

        // Journalisation
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'old_values' => $oldValues,
                'new_values' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ])
            ->log('Mise à jour du profil');

        return Redirect::route('profile.index')->with('success', 'Profile updated');
    }
}
