@extends('layouts.app')

@section('title', 'Daftar — Kopi Nusantara')
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
            <p class="auth-visual-tagline">Bergabunglah dengan komunitas pencinta kopi</p>

            <ul class="auth-feature-list">
                <li>
                    <span class="feature-icon">🎁</span>
                    <span>Daftar gratis, nikmati langsung</span>
                </li>
                <li>
                    <span class="feature-icon">📦</span>
                    <span>Lacak pesanan secara real-time</span>
                </li>
                <li>
                    <span class="feature-icon">💝</span>
                    <span>Kumpulkan poin setiap transaksi</span>
                </li>
                <li>
                    <span class="feature-icon">🏷️</span>
                    <span>Akses promo & diskon eksklusif</span>
                </li>
            </ul>

            <div class="mt-4 d-flex gap-3">
                <div style="text-align:center;flex:1;padding:1rem;background:rgba(255,255,255,0.08);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.12);">
                    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:#FDF6ED;font-weight:800;">1.2K+</div>
                    <div style="font-size:0.7rem;color:#C8A882;">Anggota Aktif</div>
                </div>
                <div style="text-align:center;flex:1;padding:1rem;background:rgba(255,255,255,0.08);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.12);">
                    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:#FDF6ED;font-weight:800;">50+</div>
                    <div style="font-size:0.7rem;color:#C8A882;">Varian Menu</div>
                </div>
                <div style="text-align:center;flex:1;padding:1rem;background:rgba(255,255,255,0.08);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.12);">
                    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:#FDF6ED;font-weight:800;">⭐ 4.9</div>
                    <div style="font-size:0.7rem;color:#C8A882;">Rating</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Form Panel --}}
    <div class="auth-panel col-12 col-md-7">
        <div class="auth-form-wrap">
            <div class="mb-4">
                <div class="auth-logo">Buat Akun ✨</div>
                <p class="auth-subtitle">Daftar dan mulai perjalanan kopi Anda bersama kami</p>
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:0.5rem 0 0 0.5rem;border-right:0;">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name"
                               value="{{ old('name') }}"
                               placeholder="Nama lengkap Anda"
                               required autofocus
                               style="border-radius:0 0.5rem 0.5rem 0;border-left:0;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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
                               required
                               style="border-radius:0 0.5rem 0.5rem 0;border-left:0;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:0.5rem 0 0 0.5rem;border-right:0;">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               placeholder="Minimal 8 karakter"
                               required
                               style="border-radius:0;border-left:0;border-right:0;">
                        <button class="input-group-text" type="button" id="togglePassword" title="Tampilkan/Sembunyikan">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text mt-1">
                        <i class="bi bi-shield-check me-1"></i>Gunakan minimal 8 karakter dengan kombinasi huruf dan angka
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:0.5rem 0 0 0.5rem;border-right:0;">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="password_confirmation" name="password_confirmation"
                               placeholder="Ulangi password Anda"
                               required
                               style="border-radius:0;border-left:0;border-right:0;">
                        <button class="input-group-text" type="button" id="toggleConfirm" title="Tampilkan/Sembunyikan">
                            <i class="bi bi-eye" id="eyeIcon2"></i>
                        </button>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-auth mb-3">
                    <i class="bi bi-person-plus me-2"></i>Buat Akun Sekarang
                </button>

                <div class="auth-divider">atau</div>

                <div class="text-center">
                    <p style="color:#6B4C3B;font-size:0.9rem;margin:0;">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" style="color:#6B3A2A;font-weight:700;">
                            Masuk di sini →
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePw(inputId, iconId) {
        const el = document.getElementById(inputId);
        const ic = document.getElementById(iconId);
        if (el.type === 'password') {
            el.type = 'text';
            ic.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            el.type = 'password';
            ic.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
    document.getElementById('togglePassword').addEventListener('click', () => togglePw('password', 'eyeIcon'));
    document.getElementById('toggleConfirm').addEventListener('click', () => togglePw('password_confirmation', 'eyeIcon2'));
</script>
@endpush
@endsection
