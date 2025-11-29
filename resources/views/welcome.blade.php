@extends('layouts.guest')

@section('content')
    <p class="text-muted">Welcome to the Client Portal companion app. Please log in to view projects, log time, and submit change requests.</p>
    <div class="d-grid gap-2 mt-3">
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
    </div>
@endsection
