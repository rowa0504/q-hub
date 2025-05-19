import './bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import { Calendar } from '@fullcalendar/core';
import { likeComponent } from './likeComponent.js';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import Alpine from 'alpinejs'

let calendar;
let calendarModal = new bootstrap.Modal(document.getElementById('calendar')); // カレンダーモーダルのインスタンス
let postFormModal = new bootstrap.Modal(document.getElementById('post-form-1')); // フォームモーダルのインスタンス

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('calendar');

    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            const calendarEl = document.getElementById('calendar-container');

            // 既存のカレンダーを破棄
            if (calendar) {
                calendar.destroy();
                calendar = null;
            }

            // FullCalendar初期化
            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                selectable: true,//日付をマウスで選択できるかどうか
                events: '/api/events',
                dateClick: function(info) {
                    openPostForm(info.dateStr); // フォームモーダルを表示
                },

                eventClick: function(info) {
                    let projectId = info.event.id;
                    if (projectId) {
                        window.location.href = `/event/${projectId}/show`; // 先頭にスラッシュを追加
                    }
                    info.jsEvent.preventDefault();
                },
            });

            calendar.render();
        });
    }

    // 画像プレビュー処理（画像選択時）
    const imageInput = document.getElementById('imageInput1');
    if (imageInput) {
        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('imagePreview1').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

/**
 * 投稿フォームを開く（カレンダーモーダルを閉じ、フォームモーダルを表示）
 */
window.openPostForm = function (selectedDate) {
    // 日付をフォームに反映
    document.getElementById('startdate').value = selectedDate;
    document.getElementById('enddate').value = selectedDate;

    // カレンダーモーダルを閉じる
    calendarModal.hide();

    // フォームモーダルを表示
    postFormModal.show();
};

/**
 * 投稿フォームを閉じる（カレンダーモーダルを再度表示）
 */
window.closePostForm = function () {
    const modalElement = document.getElementById('post-form-1');
    const modalContent = modalElement.querySelector('.modal-content');

    modalContent.classList.remove('right-position'); // サイドパネル用のクラスを削除
    modalElement.classList.remove('show');
    modalElement.style.display = 'none';
    modalElement.setAttribute('aria-hidden', 'true');
    modalElement.setAttribute('tabindex', '-1');

    // カレンダーモーダルを再度表示
    calendarModal.show();
};

window.likeComponent = likeComponent;

Alpine.start();

