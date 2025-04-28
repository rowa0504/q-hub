<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class EventController extends Controller
{
    public function index()
    {
        // Eventカテゴリー（category_id = 1）の投稿だけ取得
        $all_posts = Post::where('category_id', 1)->get();

        return view('posts.categories.events.index', compact('all_posts'));
    }

    public function show($id)
    {
        return view('posts.categories.events.show');
    }

    public function indexCalendar(){
        $events = Post::where('category_id', 1)->get();

        // FullCalendarが期待する形式に変換して返す
        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->startdatetime->toIso8601String(),
                'end' => $event->enddatetime ? $event->enddatetime->toIso8601String() : null,
            ];
        });

        return response()->json($formattedEvents);
    }

}
