<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Team;
use Illuminate\Http\Request;


class TeamController extends Controller
{

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function join(Request $request, $teamId)
    {
        $user = auth()->user();
        $team = Team::findOrFail($teamId);

        // Récupère la liste des IDs des sports favoris de l'utilisateur
        $favSportsIds = $user->favoriteSports()->pluck('sports.id')->toArray();

        // Vérifie que l'équipe correspond à l'un des sports favoris
        if (!in_array($team->sport_id, $favSportsIds)) {
            return back()->with('error', 'Vous ne pouvez rejoindre que des équipes correspondant à l\'un de vos sports favoris.');
        }

        // Vérifie que l'utilisateur n'a pas déjà rejoint une équipe pour ce sport
        $alreadyInTeam = $user->teams()
            ->where('sport_id', $team->sport_id)
            ->exists();

        if ($alreadyInTeam) {
            return back()->with('error', 'Vous êtes déjà dans une équipe pour ce sport.');
        }

        // Ajoute l'utilisateur à l'équipe
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

        // Retire l'utilisateur de l'équipe
        $user->teams()->detach($team->id);

        return back()->with('success', 'Vous avez quitté l\'équipe.');
    }


    public function show($id)
    {
        $team = Team::with('users')->findOrFail($id);
        $user = auth()->user();

        $isMember = $team->users->contains('username', $user->username);

        return view('teams.show', compact('team', 'isMember'));
    }

    public function index()
    {
        $teams = Team::withCount('users')->get(); // avec le nombre de membres
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $sports = Sport::all(); // Pour choisir le sport de l’équipe
        return view('teams.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'sport_id' => $request->sport_id,
        ]);

        return redirect()->route('teams.index')->with('success', 'Équipe créée avec succès !');
    }

}
