<?php

namespace App\Listeners;

use App\Events\TrainingCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Livewire\Livewire;

class RefreshTrainingCalendar
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TrainingCreated $event)
    {
        // Rafraîchit le composant Livewire Calendar pour tous les users concernés
        Livewire::emitTo('calendar', 'refreshCalendar');
    }
}
