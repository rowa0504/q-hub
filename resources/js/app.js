import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

let calendar; // グローバルにカレンダーインスタンスを持つ

document.addEventListener('DOMContentLoaded', function () {
    let modal = document.getElementById('calendar');
    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            let calendarEl = document.getElementById('calendar-container');
            // もしすでにレンダリングしていたらdestroyして作り直す
            if (calendar) {
                calendar.destroy();
                calendar = null; // 再度カレンダーを初期化する
            }

            // FullCalendarの設定
            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: '/api/events', // APIからイベントを取得
                dateClick: function(info) {
                    let selectedDate = info.dateStr; // クリックされた日付（YYYY-MM-DD）

                    // まずページ遷移を防ぐ
                    info.jsEvent.preventDefault();

                    // モーダルを開く
                    openCreateEventModal(selectedDate);
                }
            });
            calendar.render(); // カレンダーを描画
        });
    }
});

function openCreateEventModal(selectedDate) {
    // モーダル内の日付フィールドにセット
    const startDateField = document.getElementById('startdate');
    if (startDateField) {
        startDateField.value = selectedDate; // 日付をセット
    }

    // モーダルを表示
    var myModal = new bootstrap.Modal(document.getElementById('post-form-1'));

    // モーダルが開かない場合にログを追加してデバッグ
    if (!myModal) {
        console.log("Modalの初期化に失敗しました");
    } else {
        console.log("モーダルを表示します");
        myModal.show(); // モーダルを表示
    }
}





