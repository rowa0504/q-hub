@extends('layouts.app')

@section('title', 'Admin: Reports')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-top">
        <h4 class="mb-0"><i class="fa-solid fa-flag"></i> Report Management</h4>
    </div>

    <div class="bg-white p-3 border rounded-bottom table-responsive">
        <table class="table table-hover align-middle text-secondary">
            <thead class="table-info text-dark">
                <tr>
                    <th>#ID</th>
                    <th>Reporter</th>
                    <th>Reported Action</th>
                    <th>Reasons</th>
                    <th>Reported User</th>
                    <th>Status</th>
                    <th>Warn</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                @php
                    $reportable = $report->reportable;
                    $reportedUser = $reportable?->user;
                    $reportableTitle = $reportable->title ?? '[No Title]';
                    $reportableLink = method_exists($reportable, 'getCategoryRoute') ? $reportable->getCategoryRoute() : null;
                @endphp
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->user->name ?? 'Unknown' }}</td>

                    {{-- Reported Action --}}
                    <td>
                        @if ($reportable instanceof App\Models\Post)
                            @if ($reportableLink)
                                <a href="{{ $reportableLink }}" class="text-decoration-none">
                                    [Post] {{ $reportable->title }}
                                </a>
                            @else
                                <span class="text-muted">[Post] {{ $reportable->title }}</span>
                            @endif

                        @elseif ($reportable instanceof App\Models\Comment)
                            <span>[Comment] {{ Str::limit($reportable->body, 50) }}</span>

                        @elseif ($reportable instanceof App\Models\Answer)
                            <span>[Answer] {{ Str::limit($reportable->body, 50) }}</span>

                        @elseif ($reportable instanceof App\Models\ChatMessage)
                            <span>[Chat] {{ Str::limit($reportable->body, 50) }}</span>

                        @else
                            <span class="text-muted">Unknown Content</span>
                        @endif
                    </td>

                    {{-- Reasons --}}
                    <td>
                        <ul class="mb-0">
                            @foreach ($report->reportReasonReport as $reasonReport)
                                <li>{{ $reasonReport->reason->name }}</li>
                            @endforeach
                        </ul>
                    </td>

                    {{-- Reported User --}}
                    <td>{{ $reportedUser->name ?? 'Deleted User' }}</td>

                    {{-- Status --}}
                    <td>
                        <div>
                            <strong>User:</strong>
                            @if ($reportedUser && $reportedUser->deleted_at)
                                <span class="text-danger">Banned</span>
                            @else
                                <span>{{ $report->status }}</span>
                            @endif
                        </div>
                        <div>
                            <strong>Content:</strong>
                            @if (method_exists($reportable, 'trashed') && $reportable->trashed())
                                <span class="text-danger">Deleted</span>
                            @else
                                <span>{{ $report->status }}</span>
                            @endif
                        </div>
                    </td>

                    {{-- Warn ボタン・Dismiss・表示 --}}
                    <td>
                        @if ($report->status == 'pending')
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#warnModal-{{ $reportable->id }}">
                                <i class="fa-solid fa-triangle-exclamation"></i> Warn
                            </button>
                            @include('admin.reports.modal.warn', ['post' => $reportable])

                            <form action="{{ route('admin.dismissed', $report->id) }}" method="post" class="mt-1">
                                @csrf
                                <button class="btn btn-secondary btn-sm">Dismiss</button>
                            </form>
                        @elseif ($report->status == 'warned' || $report->status == 'resolved')
                            <span class="text-success">Sent</span>
                        @endif
                    </td>

                    {{-- 管理者メッセージ --}}
                    <td>{{ $report->message }}</td>
                </tr>
                @endforeach
                {{-- @foreach($reports as $report)
                    @php
                        $post = $report->post;
                        $user = $post?->user;
                    @endphp
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->user->name ?? 'Unknown' }}</td>
                        <td>
                            @if ($post && $post->getCategoryRoute())
                                <a href="{{ $post->getCategoryRoute() }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            @else
                                <span class="text-muted">No route</span>
                            @endif
                        </td>
                        <td>
                            <ul class="mb-0">
                                @foreach ($report->reportReasonReport as $reasonReport)
                                    <li>{{ $reasonReport->reason->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $user->name ?? 'Deleted User' }}</td>
                        <td>
                            <div>
                                <strong>User:</strong>
                                @if ($user && $user->deleted_at)
                                    <span class="text-danger">Banned</span>
                                @else
                                    <span>{{ $report->status }}</span>
                                @endif
                            </div>
                            <div>
                                <strong>Post:</strong>
                                @if ($post && method_exists($post, 'trashed') && $post->trashed())
                                    <span class="text-danger">Banned</span>
                                @else
                                    <span>{{ $report->status }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if ($report->status == 'pending')
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#warnModal-{{ $post->id }}">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Warn
                                </button>
                                @include('admin.reports.modal.warn', ['post' => $post])

                                <form action="{{ route('admin.dismissed', $report->id) }}" method="post">
                                    @csrf

                                    <button class="btn btn-secondary">dismissed</button>
                                </form>
                            @elseif ($report->status == 'warned' || $report->status == 'resolved')
                                <span class="text-success">Sent</span>
                            @endif
                        </td>
                        <td>
                            {{ $report->message }}
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection
