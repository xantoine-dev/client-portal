@extends('layouts.guest')

@section('content')
    <p class="text-muted mb-4">For security, please confirm your password to continue.</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required autofocus>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
@endsection
