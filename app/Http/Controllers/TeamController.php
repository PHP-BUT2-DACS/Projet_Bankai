<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function join(Request $request, $teamId)
    {
        $user = auth()->user();
        $team = Team::findOrFail($teamId);

        // Vérifie que l'équipe correspond au sport favori de l'utilisateur
        if ($team->sport_id !== $user->sport_id) {
            return back()->with('error', 'Vous ne pouvez rejoindre que des équipes de votre sport favori.');
        }

        $user->teams()->attach($team->id);

        return back()->with('success', 'Vous avez rejoint l\'équipe !');
    }

}
