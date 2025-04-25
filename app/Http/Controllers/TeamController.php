<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function join(Request $request, $teamId)
    {
        $user = auth()->user();
        $team = Team::findOrFail($teamId);


        $user->teams()->attach($team->id);

        return back()->with('success', 'Vous avez rejoint l\'équipe !');
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
