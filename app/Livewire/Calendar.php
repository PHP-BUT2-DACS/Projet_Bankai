<?php

namespace App\Livewire;

use App\Models\Conference;
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

        // Toutes les conférences (pas seulement celles de l'utilisateur)
        $allConferences = Conference::with('users')->get()->map(function($conference) use ($user) {
            // Vérifier si l'utilisateur participe à cette conférence
            $isParticipating = $conference->users->contains($user->id);

            return [
                'id' => $conference->id,
                'title' => 'Conférence : ' . $conference->title . ($isParticipating ? ' (Inscrit)' : ''),
                'start' => $conference->start,
                'end' => $conference->end,
                'color' => $isParticipating ? '#4CAF50' : '#FF9800', // Vert si inscrit, Orange sinon
                'extendedProps' => [
                    'isParticipating' => $isParticipating
                ]
            ];
        });

        return $teamTrainings->merge($allConferences)->toArray();
    }

    /**
     * Basculer la participation d'un utilisateur à une conférence
     */
    public function toggleParticipation($conferenceId)
    {
        $user = Auth::user();
        $conference = Conference::findOrFail($conferenceId);

        if ($conference->users->contains($user->id)) {
            // Se désinscrire
            $conference->users()->detach($user->id);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Vous êtes désinscrit de cette conférence.']);
        } else {
            // S'inscrire
            $conference->users()->attach($user->id);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Vous êtes inscrit à cette conférence.']);
        }

        // Au lieu de dispatcher un événement refreshCalendar
        // On renvoie la liste d'événements mise à jour directement
        $this->dispatch('updateCalendarEvents', ['events' => $this->getEventsProperty()]);
    }

    public function handleToggleParticipation($payload)
    {
        $conferenceId = is_array($payload) ? ($payload['conferenceId'] ?? null) : $payload;

        if (!$conferenceId) {
            return;
        }

        $user = Auth::user();
        $conference = Conference::findOrFail($conferenceId);

        if ($conference->users->contains($user->id)) {
            $conference->users()->detach($user->id);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Vous êtes désinscrit de cette conférence.']);
        } else {
            $conference->users()->attach($user->id);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Vous êtes inscrit à cette conférence.']);
        }

        // Mise à jour du calendrier avec les nouveaux événements
        $this->dispatch('updateCalendarEvents', ['events' => $this->getEventsProperty()]);
    }

    public function render()
    {
        return view('livewire.calendar', [
            'events' => $this->getEventsProperty() // Appelle explicitement la méthode
        ]);
    }
}
