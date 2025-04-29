@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl p-4 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">チャットルーム：{{ $chatdate->post->title }}</h2>

    {{-- 参加者リスト --}}
    <div class="mb-4">
        <h3 class="text-lg font-semibold">参加者（{{ $chatdate->users->count() }} / {{ $chatdate->post->max }}）</h3>
        <ul class="list-disc pl-5">
            @foreach ($chatdate->users as $user)
                <li>{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>

    {{-- メッセージ一覧 --}}
    <div class="border p-4 mb-4 h-64 overflow-y-scroll bg-gray-100 rounded">
        {{-- @foreach ($chatMessages as $message)
            <div class="mb-3">
                <strong>{{ $message->user->name }}</strong>
                <span class="text-sm text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                <p class="ml-2">{{ $message->body }}</p>
            </div>
        @endforeach --}}
    </div>

    {{-- メッセージ送信フォーム --}}
    <form action="#" method="POST">
        @csrf
        <div class="flex">
            <textarea name="body" class="flex-1 p-2 border rounded-l" rows="2" placeholder="メッセージを入力..."></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">送信</button>
        </div>
    </form>

    {{-- チャットルーム退出ボタン --}}
    <form action="#" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="text-red-600 underline">チャットルームを退出する</button>
    </form>
</div>
@endsection
