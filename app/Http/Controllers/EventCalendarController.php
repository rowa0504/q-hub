<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class EventCalendarController extends Controller
{
    public function index(){
        // イベントデータを取得（適宜変更）
        $events = Post::where('category_id', 1)->get();

        // FullCalendarが期待する形式に変換して返す
        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->startdatetime,
                'end' => $event->enddatetime ? $event->enddatetime : null,
            ];
        });

        return response()->json($formattedEvents);
    }
}
