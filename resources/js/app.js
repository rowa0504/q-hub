import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

let calendar; // グローバルにカレンダーインスタンスを持つ

document.addEventListener('DOMContentLoaded', function () {
    let modal = document.getElementById('calendar'); // モーダルのIDに注意
    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            let calendarEl = document.getElementById('calendar-container');
            // もしすでにレンダリングしていたらdestroyして作り直す
            if (calendar) {
                calendar.destroy();
            }

            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                eventClick: function(info) {
                    let eventId = info.event.id;
                    if (eventId) {
                        window.location.href = `event/${eventId}/show`;
                    }
                    info.jsEvent.preventDefault();
                },
                dateClick: function(info) {
                    let selectedDate = info.dateStr;
                    window.location.href = `event/create?date=${selectedDate}`;
                },
                // eventsをeventSourcesに変更して、非同期でデータを取得
                eventSources: [{
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch('/api/events')
                            .then(response => response.json())
                            .then(events => {
                                successCallback(events); // イベントデータをカレンダーに渡す
                            })
                            .catch(error => failureCallback(error)); // エラー処理
                    }
                }]
            });
            calendar.render();
        });
    }
});


