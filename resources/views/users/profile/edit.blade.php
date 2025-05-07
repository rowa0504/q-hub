@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container py-4" style="max-width: 500px;">
        <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="text-center mb-4">
                <div class="position-relative d-inline-block" id="avatarContainer">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="avatar"
                            class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                            width="120" height="120" id="avatarPreview">
                    @else
                        <i class="fa-solid fa-circle-user fa-9x text-secondary" id="avatarPreview"
                           style="width: 120px; height: 120px;"></i>
                    @endif

                    <label for="avatarInput"
                        class="position-absolute top-0 start-100 translate-middle p-1 bg-light rounded-circle border shadow"
                        style="cursor: pointer;">
                        <i class="fas fa-pen"></i>
                    </label>
                    <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">
                </div>
            </div>

            <!-- JS：<i>を<img>に差し替える処理を含む -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('avatarInput').addEventListener('change', function (event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                let preview = document.getElementById('avatarPreview');

                                // <i>タグだった場合は <img> に置き換え
                                if (preview.tagName.toLowerCase() === 'i') {
                                    const img = document.createElement('img');
                                    img.id = 'avatarPreview';
                                    img.src = e.target.result;
                                    img.className = 'rounded-circle';
                                    img.width = 120;
                                    img.height = 120;

                                    const container = document.getElementById('avatarContainer');
                                    container.replaceChild(img, preview);
                                } else {
                                    preview.src = e.target.result;
                                }
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                });
            </script>




            <!-- ユーザー名 -->
            <input type="text" name="name" class="form-control mt-3 text-center fw-bold" placeholder="Username"
                value="{{ old('name', $user->name) }}">

            <hr>

            <!-- Email -->
            <div class="mb-3">
                <label class="fw-bold">Email:</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <!-- Enrollment Period -->
            <div class="mb-3">
                <label class="fw-bold">Enrollment Start Date:</label>
                <input type="date" name="enrollment_start" class="form-control"
                    value="{{ old('enrollment_start', $user->enrollment_start) }}">
            </div>

            <div class="mb-3">
                <label class="fw-bold">Enrollment End Date:</label>
                <input type="date" name="enrollment_end" class="form-control"
                    value="{{ old('enrollment_end', $user->enrollment_end) }}">
            </div>

            <!-- Graduation Status -->
            <div class="mb-3">
                <label class="fw-bold">Graduation Status:</label>
                <select name="graduation_status" class="form-select">
                    <option value="Graduated"
                        {{ old('graduation_status', $user->graduation_status) == 'Graduated' ? 'selected' : '' }}>Graduated
                    </option>
                    <option value="Enrolled"
                        {{ old('graduation_status', $user->graduation_status) == 'Enrolled' ? 'selected' : '' }}>Enrolled
                    </option>
                </select>
            </div>

            <!-- Introduction -->
            <div class="mb-4">
                <label class="fw-bold">Introduction:</label>
                <textarea name="introduction" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
            </div>

            <hr>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-info text-white fw-bold">Save</button>
                <a href="{{ route('profile.index', Auth::user()->id) }}" class="btn btn-outline-dark fw-bold">Back</a>
            </div>
        </form>
    </div>
@endsection
