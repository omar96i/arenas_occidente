<x-filament-panels::page>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        const shifts = @json($shifts);
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: shifts.map(shift => ({
                title: shift.user.name, // Puedes cambiar esto por el título que quieras para el evento
                start: shift.date,
                allDay: true
            }))
        });
        setTimeout(() => {
            calendar.render();
        }, 1000);

      });

    </script>
    <div id='calendar' style="height: 300px;"></div>
</x-filament-panels::page>
