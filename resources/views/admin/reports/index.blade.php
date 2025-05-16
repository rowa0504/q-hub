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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        @php
                            $reportable = $report->reportable;
                            $reportedUser =
                                $reportable instanceof App\Models\User ? $reportable : $reportable?->user ?? null;
                            $reportableTitle = $reportable->title ?? '[No Title]';
                            $reportableLink =
                                $reportable && method_exists($reportable, 'getCategoryRoute')
                                    ? $reportable->getCategoryRoute()
                                    : null;
                        @endphp

                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->user->name ?? 'Unknown' }}</td>

                            {{-- Reported Action --}}
                            <td>
                                @if ($reportable instanceof App\Models\Post)
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#postDetailModal-{{ $report->id }}">
                                        [Post] {{ $reportable->title }}
                                    </a>
                                    @include('admin.reports.modal.posts', ['report' => $report])
                                @elseif ($reportable instanceof App\Models\Comment)
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#commentDetailModal-{{ $report->id }}">
                                        [Comment] {{ Str::limit($reportable->body, 50) }}
                                    </a>
                                    @include('admin.reports.modal.comments', ['report' => $report])
                                @elseif ($reportable instanceof App\Models\Answer)
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#answerDetailModal-{{ $report->id }}">
                                        [Answer] {{ Str::limit($reportable->body, 50) }}
                                    </a>
                                    @include('admin.reports.modal.answers', ['report' => $report])
                                @elseif ($reportable instanceof App\Models\ChatMessage)
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#chatDetailModal-{{ $report->id }}">
                                        [Chat] {{ Str::limit($reportable->body, 50) }}
                                    </a>
                                    @include('admin.reports.modal.chat', ['report' => $report])
                                @elseif ($reportable instanceof App\Models\User)
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#userDetailModal-{{ $report->id }}">
                                        [User] {{ $reportable->name ?? 'Unknown User' }}
                                    </a>
                                    @include('admin.reports.modal.users', ['report' => $report])
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
                            <td>
                                @if ($reportedUser)
                                    <a href="{{ route('admin.reportedUser', $reportedUser->id) }}"
                                        class="text-decoration-none">
                                        {{ $reportedUser->name ?? 'Deleted User' }}
                                    </a>
                                @else
                                    <span class="text-muted">Unknown User</span>
                                @endif
                            </td>

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
                                    @if ($reportable && method_exists($reportable, 'trashed') && $reportable->trashed())
                                        <span class="text-danger">Deleted</span>
                                    @else
                                        <span>{{ $report->status }}</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Warn ボタン・Dismiss・表示 --}}
                            <td>
                                @if ($report->status == 'pending')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#warnModal-{{ $report->id }}">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Warn
                                    </button>
                                    @include('admin.reports.modal.warn', ['report' => $report])

                                    <form action="{{ route('admin.dismissed', $report->id) }}" method="post"
                                        class="mt-1">
                                        @csrf
                                        <button class="btn btn-secondary btn-sm">Dismiss</button>
                                    </form>
                                @elseif ($report->status == 'warned' || $report->status == 'resolved')
                                    <button class="btn btn-success btn-sm w-100 text-start" data-bs-toggle="modal"
                                        data-bs-target="#warnMessage-{{ $report->id }}">
                                        <i class="fa-solid fa-envelope-open-text"></i> Sent
                                    </button>

                                    @include('admin.reports.modal.warnMessage-modal', [
                                        'report' => $report,
                                    ])
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
