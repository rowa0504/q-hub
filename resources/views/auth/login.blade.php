@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <div class="w-100" style="max-width: 400px;">
            <!-- ロゴ -->
            <div class="text-center mb-2">
                <img src="{{ asset('images/Zinnbei1.png') }}" alt="logo" style="max-width: 150px;">
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-info">
                                {{ __('Login') }}
                            </button>
                        </div>

                            <div class="d-grid mt-2">
                                <a href="{{ route('guest.index') }}" class="btn btn-secondary">
                                    Continue as Guest
                                </a>
                            </div>
                    </form>

                    <div class="text-center mt-3">
                        <span>Don't have an account?</span>
                        <a href="{{ route('register') }}" class="btn btn-link">Register</a>
                    </div>
                    <div class="mt-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-outline-info">
                                <img src="{{ asset('images/google.icon.svg') }}" alt="Google Login" style="width: 40px; height: 40px;">
                                </i> Login with Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>

        </html>
