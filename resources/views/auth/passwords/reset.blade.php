@extends('layouts.app')

@section('title', 'Reset Password')
@section('body-class', 'auth-page')

@section('auth')
<div class="auth-container">
    <div class="card auth-card">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="h3 auth-logo">Coffee Shop</h1>
                <p class="auth-subtitle">Reset Password</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-coffee">Reset Password</button>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0"><a href="{{ route('login') }}">Kembali ke login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
