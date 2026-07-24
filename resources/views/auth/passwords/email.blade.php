@extends('layouts.app')

@section('title', 'Lupa Password')
@section('body-class', 'auth-page')

@section('auth')
<div class="auth-container">
    <div class="card auth-card">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="h3 auth-logo">Coffee Shop</h1>
                <p class="auth-subtitle">Reset Password</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-coffee">Kirim Link Reset Password</button>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0"><a href="{{ route('login') }}">Kembali ke login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
