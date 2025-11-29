@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Verify your email address</h2>
                    <p class="text-muted">Before accessing the portal, please verify your email. If you didn't receive the email, we will gladly send another.</p>
                    <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Resend verification email</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
