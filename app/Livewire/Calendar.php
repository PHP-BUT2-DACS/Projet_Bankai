<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    protected $listeners = ['refreshCalendar' => '$refresh'];

    public function getEventsProperty()
    {
        $user = Auth::user();

        // Entraînements des équipes de l'utilisateur
        $teamTrainings = Training::whereHas('team', function($query) use ($user) {
            $query->whereIn('id', $user->teams->pluck('id'));
        })->get()->map(function($training) {
            return [
                'title' => 'Entraînement ' . $training->team->name . ' : ' . $training->title,
                'start' => $training->start,
                'end' => $training->end,
                'color' => '#2196F3' // Bleu pour les entraînements
            ];
        });

        // Conférences de l'utilisateur
        $userConferences = $user->conferences()->get()->map(function($conference) {
            return [
                'title' => 'Conférence : ' . $conference->title,
                'start' => $conference->start,
                'end' => $conference->end,
                'color' => '#4CAF50' // Vert pour les conférences
            ];
        });

        return $teamTrainings->merge($userConferences)->toArray();
    }

    public function render()
    {
        return view('livewire.calendar', [
            'events' => $this->getEventsProperty() // Appelle explicitement la méthode
        ]);
    }
}
