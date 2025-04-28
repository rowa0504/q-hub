@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4" style="max-width: 600px;">
  <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="text-center mb-4">
      <!-- アイコン -->
      <div class="position-relative d-inline-block">
        @if ($user->avatar)
          <img src="{{ $user->avatar }}" alt="avatar" class="rounded-circle" width="120" height="120" id="avatarPreview">
        @else
          <img src="{{ asset('images/Zinnbei_button.png') }}" alt="avatar" class="rounded-circle" width="120" height="120" id="avatarPreview">
        @endif
        <label for="avatarInput" class="position-absolute top-0 start-100 translate-middle p-1 bg-light rounded-circle border shadow" style="cursor: pointer;">
          <i class="fas fa-pen"></i>
        </label>
        <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">
      </div>

      <!-- ユーザー名 -->
      <input type="text" name="name" class="form-control mt-3 text-center fw-bold" placeholder="Username" value="{{ old('name', $user->name) }}">
    </div>

    <hr>

    <!-- Email -->
    <div class="mb-3">
      <label class="fw-bold">Email:</label>
      <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>

    <!-- Password（変更しないのでDisabled） -->
    <div class="mb-3">
      <label class="fw-bold">Password:</label>
      <input type="password" class="form-control" value="***************">
    </div>

    <!-- Introduction -->
    <div class="mb-4">
      <label class="fw-bold">Introduction:</label>
      <textarea name="introduction" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
    </div>

    <hr>

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-info text-white fw-bold">Save</button>
      <a href="{{ route('profile.index') }}" class="btn btn-outline-dark fw-bold">Back</a>
    </div>
  </form>
</div>
@endsection
