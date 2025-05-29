{{-- 参加者表示モーダル --}}
<div class="modal fade" id="participant-user-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-regular fa-hand"></i> Participants
                </h3>
            </div>
            <div class="modal-body">
                <!-- ✅ JavaScriptでここに参加者を描画 -->
                <div id="participants-list-{{ $post->id }}">
                    @foreach ($post->participations as $participation)
                        @php $user = $participation->user; @endphp
                        <div class="row align-items-center mb-3 participant">
                            <div class="col-auto">
                                <a href="{{ route('profile.index', $user->id) }}">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{ route('profile.index', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-target^="#participant-user-"]').forEach(button => {
        button.addEventListener('click', event => {
            const modalId = button.getAttribute('data-bs-target');
            const postId = modalId.split('-').pop(); // "participant-user-123" -> "123"

            fetch(`/posts/${postId}/participants`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('participants-list-' + postId);
                container.innerHTML = '';

                if (data.participants.length === 0) {
                    container.innerHTML = `<p class="lead text-muted text-center">No Participants.</p>`;
                } else {
                    data.participants.forEach(user => {
                        const userHtml = `
                            <div class="row align-items-center mb-3 participant">
                                <div class="col-auto">
                                    <a href="/profile/${user.id}">
                                        ${user.avatar
                                            ? `<img src="${user.avatar}" alt="${user.name}" class="rounded-circle avatar-md">`
                                            : `<i class="fa-solid fa-circle-user text-secondary icon-md"></i>`}
                                    </a>
                                </div>
                                <div class="col ps-0 text-truncate">
                                    <a href="/profile/${user.id}" class="text-decoration-none text-dark fw-bold">${user.name}</a>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', userHtml);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading participants:', error);
            });
        });
    });
});
</script>

