@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Edit Profil</h5>

        <form method="POST" action="{{ route('user.profile.update') }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
            </div>
            <hr>
            <h6>Ganti Password</h6>
            <div class="mb-3">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="new_password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-coffee">Simpan</button>
        </form>
    </div>
</div>
@endsection
