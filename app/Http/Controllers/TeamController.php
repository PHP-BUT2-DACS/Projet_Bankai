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

        // Vérifie si l'utilisateur fait déjà partie d'une équipe de ce sport
        $alreadyInTeam = $user->teams()->where('sport_id', $user->sport_id)->exists();
        if ($alreadyInTeam) {
            return back()->with('error', 'Vous ne pouvez rejoindre qu\'une seule équipe à la fois pour votre sport favori.');
        }

        $user->teams()->attach($team->id);

        return back()->with('success', 'Vous avez rejoint l\'équipe !');
    }

    public function leave(Request $request, $teamId)
    {
        $user = auth()->user();
        $team = Team::findOrFail($teamId);

        // Vérifie que l'utilisateur fait bien partie de cette équipe
        if (!$user->teams->contains($team->id)) {
            return back()->with('error', 'Vous ne faites pas partie de cette équipe.');
        }

        $user->teams()->detach($team->id);

        return back()->with('success', 'Vous avez quitté l\'équipe.');
    }


}
