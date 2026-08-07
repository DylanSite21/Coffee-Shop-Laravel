@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="profile-page fade-in-up">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <h2 class="profile-name">{{ auth()->user()->name }}</h2>
        <p class="profile-email">{{ auth()->user()->email }}</p>
    </div>

    <form method="POST" action="{{ route('user.profile.update') }}" class="mt-4">
        @csrf @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <div class="profile-section-card">
                    <div class="section-header">
                        <i class="bi bi-person-circle"></i>
                        <h5 class="mb-0">Informasi Pribadi</h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-section-card">
                    <div class="section-header">
                        <i class="bi bi-shield-lock"></i>
                        <h5 class="mb-0">Ganti Password</h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" name="new_password" class="form-control" placeholder="Masukkan password baru">
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-actions d-flex justify-content-end gap-2">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-coffee">Batal</a>
            <button type="submit" class="btn btn-coffee">
                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
