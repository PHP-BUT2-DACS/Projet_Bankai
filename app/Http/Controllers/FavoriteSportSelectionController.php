<?php

namespace App\Http\Controllers;

use App\Models\FavoriteSportSelection;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteSportSelectionController extends Controller
{

    // Ajouter un sport en favori (depuis la page du sport)
    public function add($sportId)
    {
        $user = Auth::user();
        $user->favoriteSports()->syncWithoutDetaching([$sportId]);
        return back()->with('success', 'Sport ajouté à vos favoris !');
    }

    // Afficher le formulaire de sélection avec les sports séléctionnés déjà cochés
    public function create()
    {
        $sports = Sport::all();
        $user = Auth::user();
        $selectedSports = $user->favoriteSportSelections()->pluck('sport_id')->toArray();
        return view('favorite_sport_selection.create', compact('sports', 'selectedSports'));
    }

    // Enregistrer la sélection
    public function store(Request $request)
    {
        $request->validate([
            'sport_id' => 'required|array',
            'sport_id.*' => 'exists:sports,id',
        ]);

        $user = Auth::user();

        // On ajoute les sports favoris
        foreach ($request->sport_id as $sportId) {
            FavoriteSportSelection::create([
                'user_id' => $user->id,
                'sport_id' => $sportId,
            ]);
        }

        return redirect()->back()->with('success', 'Sports favoris mis à jour !');
    }
}
