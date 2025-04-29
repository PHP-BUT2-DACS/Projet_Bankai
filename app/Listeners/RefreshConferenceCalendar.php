<?php

namespace App\Listeners;

use App\Events\ConferenceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Livewire\Livewire;

class RefreshConferenceCalendar
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
    public function handle(ConferenceCreated $event)
    {
        // Rafraîchit le calendrier uniquement pour l'user concerné
        Livewire::emitTo('calendar', 'refreshCalendar');
    }
}
