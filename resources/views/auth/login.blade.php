@extends('layouts.app')

@section('title', 'Masuk — Kopi Nusantara')
@section('body-class', 'auth-page')

@section('auth')
<div class="auth-container">
    {{-- Left Visual Panel --}}
    <div class="auth-visual d-none d-md-flex col-md-5">
        <div class="auth-visual-content">
            <div class="auth-visual-logo">
                <span class="logo-icon">☕</span>
                Kopi Nusantara
            </div>
            <p class="auth-visual-tagline">Dari biji pilihan, untuk secangkir cerita</p>

            <ul class="auth-feature-list">
                <li>
                    <span class="feature-icon">🌱</span>
                    <span>Biji kopi 100% lokal Indonesia</span>
                </li>
                <li>
                    <span class="feature-icon">👨‍🍳</span>
                    <span>Barista profesional bersertifikat</span>
                </li>
                <li>
                    <span class="feature-icon">⚡</span>
                    <span>Pesan & lacak pesanan real-time</span>
                </li>
                <li>
                    <span class="feature-icon">💝</span>
                    <span>Program loyalitas & poin rewards</span>
                </li>
            </ul>

            <div class="mt-4 p-3" style="background:rgba(255,255,255,0.08);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.12);">
                <div style="font-size:0.75rem;color:#D4A855;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:0.25rem;">
                    Rating Pelanggan
                </div>
                <div style="font-size:1.5rem;color:#FDF6ED;font-weight:800;font-family:'Playfair Display',serif;">
                    ⭐ 4.9 / 5.0
                </div>
                <div style="font-size:0.75rem;color:#C8A882;">Dari 1.200+ ulasan pelanggan</div>
            </div>
        </div>
    </div>

    {{-- Right Form Panel --}}
    <div class="auth-panel col-12 col-md-7">
        <div class="auth-form-wrap">
            <div class="mb-4">
                <div class="auth-logo">Selamat Datang 👋</div>
                <p class="auth-subtitle">Masuk ke akun Kopi Nusantara Anda</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:0.5rem 0 0 0.5rem;border-right:0;">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required autofocus
                               style="border-radius:0 0.5rem 0.5rem 0;border-left:0;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:0.5rem 0 0 0.5rem;border-right:0;">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               placeholder="Masukkan password"
                               required
                               style="border-radius:0;border-left:0;border-right:0;">
                        <button class="input-group-text" type="button" id="togglePassword" title="Tampilkan/Sembunyikan">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="hidden" name="remember" value="0">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Akun
                </button>

                <div class="auth-divider">atau</div>

                <div class="text-center">
                    <p style="color:#6B4C3B;font-size:0.9rem;margin:0;">
                        Belum punya akun?
                        <a href="{{ route('register') }}" style="color:#6B3A2A;font-weight:700;">
                            Daftar sekarang →
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const pwInput = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pwInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush
@endsection
