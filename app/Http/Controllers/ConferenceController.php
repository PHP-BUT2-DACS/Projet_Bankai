<?php

namespace App\Http\Controllers;

use App\Events\ConferenceCreated;
use App\Listeners\RefreshConferenceCalendar;
use App\Models\Conference;
use App\Models\Team;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::with('team')->get();
        return view('conferences.index', compact('conferences'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('conferences.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'team_id' => 'nullable|exists:team,id',
        ]);

        $conference = Conference::create($validated);

        event(new RefreshConferenceCalendar());

        return redirect()->route('calendar')->with('success', 'Conférence créée avec succès !');
    }

    public function edit(Conference $conference)
    {
        $teams = Team::all();
        return view('conferences.edit', compact('conference', 'teams'));
    }

    public function update(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'start'   => 'required|date',
            'end'     => 'required|date|after_or_equal:start',
            'team_id' => 'nullable|exists:team,id',
        ]);

        $conference->update($validated);

        return redirect()->route('conferences.index')->with('success', 'Conférence modifiée.');
    }

    public function destroy(Conference $conference)
    {
        $conference->delete();
        return redirect()->route('conferences.index')->with('success', 'Conférence supprimée.');
    }

    public function joinConference(Request $request, Conference $conference)
    {
        $user = auth()->user();
        $user->conferences()->attach($conference->id);

        // Déclenche l'événement
        event(new ConferenceCreated($user));

        return back()->with('success', 'Inscription confirmée.');
    }

}
