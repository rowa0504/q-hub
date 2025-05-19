<div class="modal fade" id="userDetailModal-{{ $report->id }}" tabindex="-1"
    aria-labelledby="userDetailModalLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="userDetailModalLabel-{{ $report->id }}">Reported User Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                @if ($report->reportable instanceof App\Models\User)
                    @php $user = $report->reportable; @endphp

                    <div class="text-center mb-4">
                        @if ($user->avatar)
                        @if (Str::startsWith($user->avatar, 'data:image'))
                            {{-- Base64形式 --}}
                            <img src="{{ $user->avatar }}" alt="avatar"
                                 class="rounded-circle bg-light" width="120" height="120">
                        @else
                            {{-- 通常のファイルパス形式 --}}
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                 class="rounded-circle bg-light" width="120" height="120">
                        @endif
                    @else
                        <i class="fa-solid fa-circle-user fa-9x text-secondary"></i>
                    @endif

                    </div>

                    <h4 class="text-center fw-bold mb-3">{{ $user->name }}</h4>

                    <ul class="list-group mb-3">
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Enrollment Start:</strong> {{ $user->enrollment_start }}</li>
                        <li class="list-group-item"><strong>Enrollment End:</strong> {{ $user->enrollment_end }}</li>
                        <li class="list-group-item"><strong>Graduation Status:</strong> {{ $user->graduation_status }}</li>
                        <li class="list-group-item"><strong>Introduction:</strong><br>{{ $user->introduction }}</li>
                    </ul>
                @else
                    <p class="text-danger">User information is not available.</p>
                @endif
            </div>

            <div class="modal-footer bg-white d-flex justify-content-between">
                <div>
                    <small class="text-muted">User ID: {{ $report->reportable->id }}</small>
                </div>
                <div>
                    @if ($report->reportable->deleted_at)
                        <form action="{{ route('admin.users.activate', $report->reportable->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-rotate-left"></i> Restore
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.deactivate', $report->reportable->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
