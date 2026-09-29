@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <style>
        .pf-page {
            --pf-espresso: #2e1d12;
            --pf-roast: #6b4226;
            --pf-crema: #c58b55;
            --pf-foam: #f7f1e8;
            --pf-line: rgba(46, 29, 18, .12);
            max-width: 960px;
            margin-inline: auto;
        }

        /* Header */
        .pf-hero {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 2rem 2.25rem;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--pf-espresso), var(--pf-roast));
            color: #fff;
            overflow: hidden;
        }

        .pf-hero::after {
            content: "";
            position: absolute;
            right: -1.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 11rem;
            height: 11rem;
            background: url("/coffee-cup-svgrepo-com.svg") no-repeat center / contain;
            opacity: .07;
            filter: brightness(0) invert(1);
            pointer-events: none;
        }

        .pf-avatar {
            flex: none;
            width: 84px;
            height: 84px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--pf-crema);
            color: var(--pf-espresso);
            font-size: 2.2rem;
            font-weight: 800;
            box-shadow: 0 0 0 5px rgba(255, 255, 255, .18);
        }

        .pf-name {
            margin: 0;
            font-size: clamp(1.4rem, 3vw, 1.9rem);
            font-weight: 800;
            line-height: 1.2;
            color: white;
        }

        .pf-email {
            margin: .25rem 0 0;
            color: rgba(255, 255, 255, .75);
            word-break: break-all;
        }

        /* Cards */
        .pf-card {
            height: 100%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 16px 40px -22px rgba(46, 29, 18, .35);
            overflow: hidden;
        }

        .pf-card-head {
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--pf-line);
        }

        .pf-card-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: var(--pf-foam);
            color: var(--pf-roast);
            font-size: 1.15rem;
        }

        .pf-card-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--pf-espresso);
        }

        .pf-card-hint {
            margin: 0;
            font-size: .82rem;
            color: #8a766a;
        }

        .pf-card-body {
            padding: 1.5rem;
        }

        /* Fields */
        .pf-label {
            display: block;
            margin-bottom: .4rem;
            font-size: .85rem;
            font-weight: 600;
            color: var(--pf-roast);
        }

        .pf-field {
            position: relative;
            display: flex;
            align-items: center;
            border: 1.5px solid var(--pf-line);
            border-radius: 12px;
            background: var(--pf-foam);
            transition: border-color .15s, box-shadow .15s, background .15s;
        }

        .pf-field:focus-within {
            background: #fff;
            border-color: var(--pf-crema);
            box-shadow: 0 0 0 4px rgba(197, 139, 85, .18);
        }

        .pf-field.is-invalid {
            border-color: #c0392b;
        }

        .pf-field>i.pf-lead {
            padding-left: .95rem;
            color: var(--pf-crema);
            font-size: 1.05rem;
        }

        .pf-field input {
            flex: 1;
            min-width: 0;
            height: 48px;
            padding: 0 .9rem;
            border: 0;
            background: transparent;
            color: var(--pf-espresso);
        }

        .pf-field input:focus {
            outline: none;
        }

        .pf-field input::placeholder {
            color: #b3a498;
        }

        .pf-eye {
            width: 44px;
            height: 48px;
            border: 0;
            background: transparent;
            color: #8a766a;
            cursor: pointer;
        }

        .pf-eye:hover {
            color: var(--pf-espresso);
        }

        .pf-error {
            margin-top: .35rem;
            font-size: .8rem;
            color: #c0392b;
        }

        .pf-group+.pf-group {
            margin-top: 1.1rem;
        }

        /* Alerts */
        .pf-alert {
            display: flex;
            gap: .7rem;
            align-items: flex-start;
            margin-top: 1.25rem;
            padding: .9rem 1.1rem;
            border-radius: 14px;
            font-size: .92rem;
        }

        .pf-alert.ok {
            background: #e9f6ee;
            color: #256b43;
        }

        /* Actions */
        .pf-actions {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
            margin-top: 1.75rem;
        }

        .pf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            height: 48px;
            padding: 0 1.5rem;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }

        .pf-btn:active {
            transform: scale(.98);
        }

        .pf-btn.ghost {
            border: 1.5px solid var(--pf-line);
            background: #fff;
            color: var(--pf-roast);
        }

        .pf-btn.ghost:hover {
            background: var(--pf-foam);
        }

        .pf-btn.solid {
            border: 0;
            background: var(--pf-espresso);
            color: #fff;
        }

        .pf-btn.solid:hover {
            background: var(--pf-roast);
            color: #fff;
        }

        .pf-btn:focus-visible,
        .pf-eye:focus-visible {
            outline: 3px solid rgba(197, 139, 85, .55);
            outline-offset: 2px;
        }

        @media (max-width: 575px) {
            .pf-hero {
                flex-direction: column;
                text-align: center;
                padding: 1.75rem 1.25rem;
            }

            .pf-actions {
                flex-direction: column-reverse;
            }

            .pf-btn {
                width: 100%;
            }
        }
    </style>

    <div class="pf-page pb-5">
        {{-- Header --}}
        <div class="pf-hero">
            <div class="pf-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <h1 class="pf-name">{{ auth()->user()->name }}</h1>
                <p class="pf-email">{{ auth()->user()->email }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="pf-alert ok" role="status">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('user.profile.update') }}" class="mt-4">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- Personal info --}}
                <div class="col-md-6">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <div class="pf-card-icon"><i class="bi bi-person-circle"></i></div>
                            <div>
                                <h2 class="pf-card-title">Informasi pribadi</h2>
                                <p class="pf-card-hint">Nama dan email akun Anda</p>
                            </div>
                        </div>
                        <div class="pf-card-body">
                            <div class="pf-group">
                                <label class="pf-label" for="name">Nama lengkap</label>
                                <div class="pf-field @error('name') is-invalid @enderror">
                                    <i class="bi bi-person pf-lead"></i>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', auth()->user()->name) }}" required>
                                </div>
                                @error('name')
                                    <div class="pf-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="pf-group">
                                <label class="pf-label" for="email">Email</label>
                                <div class="pf-field @error('email') is-invalid @enderror">
                                    <i class="bi bi-envelope pf-lead"></i>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}" required>
                                </div>
                                @error('email')
                                    <div class="pf-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <div class="pf-card-icon"><i class="bi bi-shield-lock"></i></div>
                            <div>
                                <h2 class="pf-card-title">Ganti password</h2>
                                <p class="pf-card-hint">Kosongkan jika tidak ingin mengubah</p>
                            </div>
                        </div>
                        <div class="pf-card-body">
                            <div class="pf-group">
                                <label class="pf-label" for="current_password">Password saat ini</label>
                                <div class="pf-field @error('current_password') is-invalid @enderror">
                                    <i class="bi bi-lock pf-lead"></i>
                                    <input type="password" id="current_password" name="current_password"
                                        placeholder="Masukkan password saat ini" autocomplete="current-password">
                                    <button type="button" class="pf-eye" data-toggle="current_password"
                                        aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                                </div>
                                @error('current_password')
                                    <div class="pf-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="pf-group">
                                <label class="pf-label" for="new_password">Password baru</label>
                                <div class="pf-field @error('new_password') is-invalid @enderror">
                                    <i class="bi bi-key pf-lead"></i>
                                    <input type="password" id="new_password" name="new_password"
                                        placeholder="Masukkan password baru" autocomplete="new-password">
                                    <button type="button" class="pf-eye" data-toggle="new_password"
                                        aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                                </div>
                                @error('new_password')
                                    <div class="pf-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="pf-group">
                                <label class="pf-label" for="new_password_confirmation">Konfirmasi password baru</label>
                                <div class="pf-field">
                                    <i class="bi bi-check-circle pf-lead"></i>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                        placeholder="Ulangi password baru" autocomplete="new-password">
                                    <button type="button" class="pf-eye" data-toggle="new_password_confirmation"
                                        aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pf-actions">
                <a href="{{ route('user.dashboard') }}" class="pf-btn ghost">Batal</a>
                <button type="submit" class="pf-btn solid">
                    <i class="bi bi-check-lg"></i>Simpan perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('[data-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.toggle);
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
            });
        });
    </script>
@endsection
