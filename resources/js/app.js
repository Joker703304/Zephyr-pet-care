import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

// Inisialisasi kalender pada elemen HTML dengan ID tertentu
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            selectable: true,
            editable: true,
            dateClick: function (info) {
                alert('Tanggal dipilih: ' + info.dateStr);
            },
        });
        calendar.render();
    }
});

