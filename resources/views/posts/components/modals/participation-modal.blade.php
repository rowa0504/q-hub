<div class="modal fade" id="participant-user-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-regular fa-hand"></i> Participants
                </h3>
            </div>
            <div class="modal-body">
                @forelse ($all_user as $user)
                    @foreach ($post->participations as $participation)
                        @if($user->id === $participation->user_id)
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <a href="{{ route('profile.index',$user->id) }}">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                        @endif
                                    </a>
                                </div>
                                <div class="col ps-0 text-truncate">
                                    <a href="{{ route('profile.index',$user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @empty
                    <p class="lead text-muted text-center">No Participants.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
