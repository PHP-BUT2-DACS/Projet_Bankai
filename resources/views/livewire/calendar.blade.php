<div>
    <!-- Système de notification -->
    <div x-data="{ notification: false, message: '', type: '' }"
         x-on:notify.window="
            notification = true;
            message = $event.detail.message;
            type = $event.detail.type;
            setTimeout(() => { notification = false }, 3000)
         ">
        <template x-if="notification">
            <div x-show="notification"
                 x-transition
                 class="fixed top-4 right-4 z-50 px-5 py-4 rounded-lg shadow-lg flex items-center space-x-3"
                 :class="{
                    'bg-green-100 border border-green-300 text-green-800': type === 'success',
                    'bg-red-100 border border-red-300 text-red-800': type === 'error'
                 }">
                <svg x-show="type === 'success'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <svg x-show="type === 'error'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-sm font-medium" x-text="message"></span>
            </div>
        </template>
    </div>

    <!-- Modale d'information sur l'événement -->
    <div x-data="{
        open: false,
        title: '',
        start: '',
        end: '',
        isConference: false,
        isParticipating: false,
        conferenceId: null
    }"
         x-on:show-event-modal.window="
            open = true;
            title = $event.detail.title;
            start = $event.detail.start;
            end = $event.detail.end;
            isConference = $event.detail.isConference;
            isParticipating = $event.detail.isParticipating;
            conferenceId = $event.detail.conferenceId;
         "
         @keydown.escape.window="open = false"
         class="relative z-10">

        <template x-if="open">
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                     @click.self="open = false">

                    <!-- Overlay -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                    <!-- Contenu de la modale -->
                    <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-bold leading-6 text-gray-900" x-text="title"></h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">
                                        Début: <span x-text="new Date(start).toLocaleString('fr-FR')"></span>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Fin: <span x-text="new Date(end).toLocaleString('fr-FR')"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="open = false">
                                Fermer
                            </button>

                            <!-- Bouton d'inscription/désinscription pour les conférences -->
                            <template x-if="isConference">
                                <button type="button"
                                        :class="isParticipating ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                        class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto"
                                        @click="window.dispatchEvent(new CustomEvent('toggle-participation', {detail: {conferenceId: conferenceId}})); open = false">
                                    <span x-text="isParticipating ? 'Se désinscrire' : 'S\'inscrire'"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Boutons pour créer une conférence ou un entraînement -->
    @if (Auth::check())
        <div class="mb-4 flex justify-end space-x-3">
            <a href="{{ route('conferences.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Nouvelle Conférence
            </a>
            <a href="{{ route('trainings.create') }}"
               class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Nouvel Entraînement
            </a>

            <button wire:click="exportToCsv"
                    class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                Exporter en CSV
            </button>
        </div>
    @endif

    <div id="calendar" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow"></div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar;

            // Ajouter un écouteur pour l'événement toggle-participation
            window.addEventListener('toggle-participation', function(event) {
                // Obtenir l'ID Livewire du composant Calendar
                const livewireId = document.querySelector('[wire\\:id]').getAttribute('wire:id');

                if (livewireId) {
                    // Appeler la méthode handleToggleParticipation sur le composant Livewire
                    window.Livewire.find(livewireId).call('handleToggleParticipation', {
                        conferenceId: event.detail.conferenceId
                    });
                }
            });

            function initCalendar(initialEvents) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    events: initialEvents,
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    eventClick: function (info) {
                        const isConference = info.event.title.includes('Conférence');
                        const isParticipating = isConference && info.event.extendedProps && info.event.extendedProps.isParticipating;

                        window.dispatchEvent(new CustomEvent('show-event-modal', {
                            detail: {
                                title: info.event.title,
                                start: info.event.start,
                                end: info.event.end,
                                isConference: isConference,
                                isParticipating: isParticipating,
                                conferenceId: info.event.id
                            }
                        }));
                    },
                    eventDidMount: function (info) {
                        if (info.event.backgroundColor) {
                            info.el.style.backgroundColor = info.event.backgroundColor;
                            info.el.style.borderColor = info.event.backgroundColor;
                        }
                    },
                    height: 'auto',
                    themeSystem: 'standard',
                    dayMaxEvents: true,
                });

                calendar.render();
                return calendar;
            }

            calendar = initCalendar(@json($events));

            window.addEventListener('updateCalendarEvents', function (event) {
                calendar.getEvents().forEach(event => event.remove());
                calendar.addEventSource(event.detail.events);
            });

            document.addEventListener('livewire:update', function () {
                if (calendarEl && !calendarEl.innerHTML.trim()) {
                    calendar = initCalendar(@json($events));
                }
            });

            document.querySelector('[wire\\:click="exportToCsv"]').addEventListener('click', function() {
                Livewire.emit('exportToCsv');
            });
        });
    </script>
@endpush
