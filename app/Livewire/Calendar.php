<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Conference;
use App\Models\Training;
use Livewire\Component;

#[AllowDynamicProperties] class Calendar extends Component
{
    public function render()
    {
        $trainings = Training::with('team')->get()->map(function($t) {
            return [
                'id'    => 'training-' . $t->id,
                'title' => 'Entraînement : ' . $t->title . ($t->team ? ' (' . $t->team->name . ')' : ''),
                'start' => $t->start,
                'end'   => $t->end,
                'color' => '#1976d2',
                'type'  => 'entrainement'
            ];
        });

        $conferences = Conference::with('team')->get()->map(function($c) {
            return [
                'id'    => 'conference-' . $c->id,
                'title' => 'Conférence : ' . $c->title . ($c->team ? ' (' . $c->team->name . ')' : ''),
                'start' => $c->start,
                'end'   => $c->end,
                'color' => '#43a047',
                'type'  => 'conference'
            ];
        });

        $this->events = $trainings->merge($conferences)->values()->toArray();

        return view('livewire.calendar');
    }
}
