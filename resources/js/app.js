import './bootstrap';

import * as bootstrap from 'bootstrap'; // ← 必須
window.bootstrap = bootstrap; // ← スクリプトから使うためにグローバル化

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

let calendar; // グローバルにカレンダーインスタンスを保持

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('calendar');

    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            const calendarEl = document.getElementById('calendar-container');

            // 既存カレンダーがあれば破棄
            if (calendar) {
                calendar.destroy();
                calendar = null;
            }

            // FullCalendarの初期化
            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                // selectable: false,//日付をマウスで選択できるかどうか
                // editable: false,//ドラッグ、リサイズできるかどうか
                events: '/api/events', // イベント取得API
            });

            calendar.render();
        });
    }
});







