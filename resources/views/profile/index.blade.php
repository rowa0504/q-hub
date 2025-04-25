@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container py-3">
  <div class="row justify-content-between">

    <!-- Profile Info: for Mobile (always shown above posts) -->
    <div class="col-12 d-block d-md-none mb-3">
      <div class="bg-light rounded p-3 text-center">
        <img src="{{ asset('images/Zinnbei_button.png') }}" class="rounded-circle mb-2" width="100" height="100" alt="avatar">
        <h5 class="fw-bold">Kerem Suer</h5>
        <p class="text-muted small">"Design is intelligence made visible."</p>
        <button class="btn btn-info btn-sm text-white fw-bold">Follow</button>
        <hr>
        <div class="text-start small">
          <p><strong>Enrollment Period:</strong> Jun 15, 2024 – Jul 7, 2025</p>
          <p><strong>Graduation Status:</strong> Graduated</p>
        </div>
      </div>
    </div>

    <!-- Main Timeline -->
    <div class="col-12 col-md-8">
      <div class="d-flex justify-content-between text-center border-bottom pb-2 mb-3">
        <div><strong>Posts</strong><br>200</div>
        <div><strong>Photos/Videos</strong><br>200</div>
        <div><strong>Following</strong><br>200</div>
        <div><strong>Followers</strong><br>1M</div>
      </div>

      <!-- Posts -->
      @foreach (range(1,3) as $tweet)
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/Zinnbei_button.png') }}" class="rounded-circle" width="40" height="40" alt="avatar">
              <div class="ms-2">
                <strong>Kerem Suer</strong> <span class="text-muted small">@kerem</span>
              </div>
            </div>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur...</p>

            @if ($tweet === 2)
              <div class="ratio ratio-16x9 mb-2">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
              </div>
            @endif

            <div class="d-flex justify-content-between text-muted small">
              <span><i class="far fa-comment"></i> 12</span>
              <span><i class="fas fa-retweet"></i> 34</span>
              <span><i class="far fa-heart"></i> 56</span>
              <span><i class="fas fa-share"></i></span>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Profile Info: for Desktop (right side) -->
    <div class="col-md-4 d-none d-md-block">
      <div class="bg-light rounded p-3 text-center">
        <img src="{{ asset('images/Zinnbei_button.png') }}" class="rounded-circle mb-2" width="100" height="100" alt="avatar">
        <h5 class="fw-bold">Kerem Suer</h5>
        <p class="text-muted small">"Design is intelligence made visible."</p>
        <button class="btn btn-info btn-sm text-white fw-bold">Follow</button>
        <hr>
        <div class="text-start small">
          <p><strong>Enrollment Period:</strong> Jun 15, 2024 – Jul 7, 2025</p>
          <p><strong>Graduation Status:</strong> Graduated</p>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
