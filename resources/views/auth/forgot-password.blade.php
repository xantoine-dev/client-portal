@extends('layouts.guest')

@section('content')
    <p class="text-muted mb-4">Enter your email and we'll send a password reset link.</p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Send reset link</button>
        </div>
        <p class="mt-3 text-center">
            <a href="{{ route('login') }}">Back to login</a>
        </p>
    </form>
@endsection
