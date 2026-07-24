@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $category->name }}</h5>
        <p><strong>Slug:</strong> {{ $category->slug }}</p>
        <p><strong>Deskripsi:</strong> {{ $category->description }}</p>
        <p><strong>Status:</strong> {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
