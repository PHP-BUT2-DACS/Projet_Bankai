<?php
namespace App\Http\Controllers;

use App\Events\TrainingCreated;
use App\Models\Training;
use App\Models\Team;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::with('team')->get();
        return view('trainings.index', compact('trainings'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('trainings.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'start'   => 'required|date',
            'end'     => 'required|date|after_or_equal:start',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $training = Training::create($validated);

        event(new TrainingCreated($training));

        return redirect()->route('trainings.index')->with('success', 'Entraînement créé.');
    }

    public function edit(Training $training)
    {
        $teams = Team::all();
        return view('trainings.edit', compact('training', 'teams'));
    }

    public function update(Request $request, Training $training)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'start'   => 'required|date',
            'end'     => 'required|date|after_or_equal:start',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $training->update($validated);

        return redirect()->route('trainings.index')->with('success', 'Entraînement modifié.');
    }

    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('trainings.index')->with('success', 'Entraînement supprimé.');
    }
}
