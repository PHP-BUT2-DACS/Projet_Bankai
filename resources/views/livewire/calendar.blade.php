<div>

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
        </div>
    @endif
    <div id="calendar" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow"></div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: @json($events),
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventClick: function(info) {
                    alert('Événement : ' + info.event.title + '\nDébut : ' + info.event.start.toLocaleString('fr-FR'));
                },
                eventDidMount: function(info) {
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

            window.addEventListener('refreshCalendar', function() {
                calendar.refetchEvents();
            });

            document.addEventListener('livewire:load', function() {
                calendar.render();
            });
        });
    </script>
@endpush
