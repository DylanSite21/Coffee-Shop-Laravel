@extends('layouts.app')

@section('title', 'Masuk - Kopi Nusantara')
@section('body-class', 'auth-page')

@section('auth')
    <div class="auth-container" style="overflow:hidden;">

        {{-- Left Visual Panel --}}
        <div class="auth-visual d-none d-md-flex col-md-5">
            <div class="auth-visual-content">

                <div class="auth-visual-logo">
                    <span class="logo-icon">
                        <img src="{{ asset('coffee-cup-svgrepo-com.svg') }}"
                             alt="Logo Kopi Nusantara"
                             width="58" height="58" class="brand-logo">
                    </span>
                    Kopi Nusantara
                </div>

                <p class="auth-visual-tagline">Dari biji pilihan, untuk secangkir cerita</p>

                <ul class="auth-feature-list">
                    <li>
                        <span class="feature-icon"><i class="bi bi-flower1"></i></span>
                        <span>Biji kopi 100% lokal Indonesia</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-person-badge"></i></span>
                        <span>Barista profesional bersertifikat</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-lightning-charge"></i></span>
                        <span>Pesan &amp; lacak pesanan real-time</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-gift"></i></span>
                        <span>Program loyalitas &amp; poin rewards</span>
                    </li>
                </ul>

                <div class="auth-rating-box">
                    <div class="auth-rating-label">Rating Pelanggan</div>
                    <div class="auth-rating-value">
                        <i class="bi bi-star-fill"></i>
                        4.9 / 5.0
                    </div>
                    <div class="auth-rating-sub">Dari 1.200+ ulasan pelanggan</div>
                </div>

            </div>
        </div>

        {{-- Right Form Panel --}}
        <div class="auth-panel col-12 col-md-7">
            <div class="auth-form-wrap">

                <div class="mb-4">
                    <div class="auth-logo">Selamat Datang</div>
                    <p class="auth-subtitle">Masuk ke akun Kopi Nusantara Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-icon-left">
                                <i class="bi bi-envelope" aria-hidden="true"></i>
                            </span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   required
                                   autofocus
                                   autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-icon-left">
                                <i class="bi bi-lock" aria-hidden="true"></i>
                            </span>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password"
                                   required
                                   autocomplete="current-password">
                            <button class="input-group-text input-group-icon-right"
                                    type="button"
                                    id="togglePassword"
                                    aria-label="Tampilkan atau sembunyikan password"
                                    title="Tampilkan / Sembunyikan Password">
                                <i class="bi bi-eye" id="eyeIcon" aria-hidden="true"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="hidden" name="remember" value="0">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="remember"
                                   name="remember"
                                   value="1"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Akun
                    </button>

                    <div class="auth-divider">atau</div>

                    <div class="text-center">
                        <p class="auth-register-text">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="auth-register-link">
                                Daftar sekarang <i class="bi bi-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle Password Visibility
            (function() {
                const toggle = document.getElementById('togglePassword');
                const pwInput = document.getElementById('password');
                const icon = document.getElementById('eyeIcon');

                if (!toggle || !pwInput || !icon) return;

                toggle.addEventListener('click', function() {
                    const isPassword = pwInput.type === 'password';
                    pwInput.type = isPassword ? 'text' : 'password';
                    icon.classList.toggle('bi-eye', !isPassword);
                    icon.classList.toggle('bi-eye-slash', isPassword);
                    pwInput.focus();
                });

                toggle.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggle.click();
                    }
                });
            })();
        </script>
    @endpush

    {{-- GSAP Animations --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap === 'undefined') return;

            const mm = gsap.matchMedia();

            mm.add('(prefers-reduced-motion: no-preference)', () => {
                // DOM Selection
                const visualItems = gsap.utils.toArray('.auth-visual-content > *:not(ul)');
                const features    = gsap.utils.toArray('.auth-feature-list li');
                const formItems   = gsap.utils.toArray(
                    '.auth-form-wrap > .mb-4, .auth-form-wrap > .alert, .auth-form-wrap form > *'
                );

                const leftAll = [...visualItems, ...features];
                const all     = [...leftAll, ...formItems];

                // Entrance Animation
                gsap.set(all, { transition: 'none' });

                gsap.timeline({
                    defaults: { ease: 'power3.out' },
                    onComplete: () => gsap.set(all, {
                        clearProps: 'transform,opacity,transition'
                    })
                })
                .from(visualItems, {
                    x: -50, opacity: 0, duration: 0.7, stagger: 0.1
                }, 0)
                .from(features, {
                    x: -40, opacity: 0, duration: 0.5, stagger: 0.12
                }, 0.3)
                .from(formItems, {
                    x: 50, opacity: 0, duration: 0.6, stagger: 0.07
                }, 0.1);

                // Exit Animation -> Register
                const registerLink = document.querySelector('a[href*="register"]');

                if (registerLink) {
                    registerLink.addEventListener('click', (e) => {
                        if (e.ctrlKey || e.metaKey || e.shiftKey || e.button !== 0) return;

                        e.preventDefault();
                        const href = registerLink.href;

                        gsap.set(all, { transition: 'none' });

                        gsap.timeline({
                            onComplete: () => window.location.href = href
                        })
                        .to(leftAll, {
                            x: -50, opacity: 0, duration: 0.35,
                            ease: 'power2.in', stagger: 0.03
                        }, 0)
                        .to(formItems, {
                            x: 50, opacity: 0, duration: 0.35,
                            ease: 'power2.in', stagger: 0.03
                        }, 0);
                    });
                }
            });

            window.addEventListener('beforeunload', () => mm.revert());
        });
    </script>
@endsection