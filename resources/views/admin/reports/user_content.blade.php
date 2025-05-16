@extends('layouts.app')

@section('title', 'Reported User Content')

@section('content')
    <div class="container">
        <h4 class="mb-4">
            <i class="fa-solid fa-user-shield me-2"></i>Content by {{ $user->name ?? 'Deleted User' }}
        </h4>

        <div class="mb-4">
            <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>

        <ul class="nav nav-tabs mb-3" id="contentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                    type="button">Posts</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments"
                    type="button">Comments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="answers-tab" data-bs-toggle="tab" data-bs-target="#answers"
                    type="button">Answers</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button">Chat
                    Messages</button>
            </li>
        </ul>

        <div class="tab-content border rounded p-3 bg-white" id="contentTabsContent">
            {{-- Posts --}}
            <div class="tab-pane fade show active" id="posts" role="tabpanel">
                <h5>Posts</h5>
                <table class="table table-hover align-middle text-secondary">
                    <thead class="table-info text-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Title</th>
                            <th>User</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    @if ($post->getCategoryRoute())
                                        <a href="{{ $post->getCategoryRoute() }}" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                    @else
                                        <span class="text-muted">No route</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($post->user)
                                        {{ $post->user->name }}
                                    @else
                                        <span class="text-muted">[Unknown]</span>
                                    @endif
                                </td>

                                <td>{{ $post->category->name ?? 'N/A' }}</td>
                                <td>{{ $post->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($post->deleted_at)
                                        <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                                    @else
                                        <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($post->deleted_at)
                                        <form action="{{ route('admin.posts.activate', $post->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-rotate-left"></i> Restore
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.posts.deactivate', $post->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center my-pagination">
                    {{ $posts->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- Comments --}}
            <div class="tab-pane fade" id="comments" role="tabpanel">
                <h5>Comments</h5>
                <table class="table table-hover align-middle text-secondary">
                    <thead class="table-info text-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Comment</th>
                            <th>User</th>
                            <th>Post</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>{{ Str::limit($comment->body, 50) }}</td>
                                <td>
                                    @if ($comment->user)
                                        <a href="{{ route('profile.index', $comment->user->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $comment->user->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Unknown]</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($comment->post)
                                        <a href="{{ $comment->post->getCategoryRoute() }}" class="text-decoration-none">
                                            {{ $comment->post->title ?? 'Post #' . $comment->post_id }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Deleted Post]</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($comment->deleted_at)
                                        <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                                    @else
                                        <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($comment->deleted_at)
                                        <form action="{{ route('admin.comments.activate', $comment->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-rotate-left"></i> Restore
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.comments.deactivate', $comment->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No comments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center my-pagination">
                    {{ $comments->links() }}
                </div>
            </div>

            {{-- Answers --}}
            <div class="tab-pane fade" id="answers" role="tabpanel">
                <h5>Answers</h5>
                <table class="table table-hover align-middle text-secondary">
                    <thead class="table-info text-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Answer</th>
                            <th>User</th>
                            <th>Post</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($answers as $answer)
                            <tr>
                                <td>{{ $answer->id }}</td>
                                <td>{{ Str::limit($answer->body, 50) }}</td>
                                <td>
                                    @if ($answer->user)
                                        <a href="{{ route('profile.index', $answer->user->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $answer->user->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Unknown]</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($answer->post)
                                        <a href="{{ $answer->post->getCategoryRoute() }}" class="text-decoration-none">
                                            {{ $answer->post->title ?? 'Post #' . $answer->post_id }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Deleted Post]</span>
                                    @endif
                                </td>
                                <td>{{ $answer->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($answer->deleted_at)
                                        <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                                    @else
                                        <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($answer->deleted_at)
                                        <form action="{{ route('admin.answers.activate', $answer->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-rotate-left"></i> Restore
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.answers.deactivate', $answer->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No answers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center my-pagination">
                    {{ $answers->links() }}
                </div>
            </div>

            {{-- Chat Messages --}}
            <div class="tab-pane fade" id="chat" role="tabpanel">
                <h5>Chat Messages</h5>
                <table class="table table-hover align-middle text-secondary">
                    <thead class="table-info text-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Message</th>
                            <th>User</th>
                            <th>Post</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($chatMessages as $chatMessage)
                            <tr>
                                <td>{{ $chatMessage->id }}</td>
                                <td>{{ Str::limit($chatMessage->body, 50) }}</td>
                                <td>
                                    @if ($chatMessage->user)
                                        <a href="{{ route('profile.index', $chatMessage->user->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $chatMessage->user->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Unknown]</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($chatMessage->chatRoom && $chatMessage->chatRoom->post)
                                        <a href="{{ $chatMessage->chatRoom->post->getCategoryRoute() }}"
                                            class="text-decoration-none">
                                            {{ $chatMessage->chatRoom->post->title ?? 'Post #' . $chatMessage->chatRoom->post_id }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Deleted Post]</span>
                                    @endif
                                </td>
                                <td>{{ $chatMessage->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($chatMessage->deleted_at)
                                        <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                                    @else
                                        <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($chatMessage->deleted_at)
                                        <form action="{{ route('admin.chatMessages.activate', $chatMessage->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-rotate-left"></i> Restore
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.chatMessages.deactivate', $chatMessage->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No chat messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center my-pagination">
                    {{ $chatMessages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
