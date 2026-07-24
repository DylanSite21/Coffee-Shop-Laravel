@extends('layouts.app')

@section('title', 'Verifikasi Email')
@section('body-class', 'auth-page')

@section('auth')
<div class="auth-container">
    <div class="card auth-card">
        <div class="card-body text-center">
            <h1 class="h3 auth-logo">Coffee Shop</h1>
            <p class="auth-subtitle">Verifikasi email Anda</p>
            <div class="alert alert-info">
                Link verifikasi telah dikirim ke email Anda.
            </div>
        </div>
    </div>
</div>
@endsection
