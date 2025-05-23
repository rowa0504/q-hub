<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class EventCalendarController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(){
        // イベントデータを取得（適宜変更）
        $events = $this->post
            ->where('category_id', 1)
            ->whereDate('startdatetime', '>=', now()->toDateString())
            ->get();

        // FullCalendarが期待する形式に変換して返す
        $formattedEvents = $events->map(function ($event) {
            return [
                'id'    => $event->id,
                'title' => $event->description,
                'start' => $event->startdatetime,
                'end'   => $event->enddatetime ? $event->enddatetime : null,
            ];
        });

        return response()->json($formattedEvents);
    }
}
