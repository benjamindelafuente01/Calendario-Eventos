/*
    Script created by: Benjamin
    date: 2024/09/20
*/

/*******************************
*      Cargar calendario       *
*******************************/
document.addEventListener('DOMContentLoaded', function() {

    // Obtenemos el div con el id del calendario
    var calendarEl = document.getElementById('calendar');

    // Creamos calendario
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        // timeZone: 'America/Los_Angeles' // Zona horaria
        events: '../Controllers/cargarEventos_controller.php',
        // [
        //     {
        //         title: 'Prueba Evento 1',
        //         start: '2024-09-25T15:30',
        //         end: '2024-09-27T20:30',
        //         color: '#a8120d',
        //         textColor: '#1E2B37'
        //     }
        // ]
        eventTimeFormat: {              // Formato de tiempo para los eventos
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false             // Para usar formato de 24 horas
        }
    });
    calendar.render();

    // Escuchar el evento personalizado (cuando se crea un nuevo evento) y refrescar el calendario
    document.addEventListener('actualizarCalendario', function() {
        calendar.refetchEvents();
    });
});
