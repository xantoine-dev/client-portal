@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Log in</button>
        </div>
        <p class="mt-3 text-center">
            Need an account? <a href="{{ route('register') }}">Register</a>
        </p>
    </form>
@endsection
