<?php


namespace App\Providers;

use App\Events\ConferenceCreated;
use App\Events\TrainingCreated;
use App\Listeners\RefreshConferenceCalendar;
use App\Listeners\RefreshTrainingCalendar;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        TrainingCreated::class => [
            RefreshTrainingCalendar::class,
        ],
        ConferenceCreated::class => [
            RefreshConferenceCalendar::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
