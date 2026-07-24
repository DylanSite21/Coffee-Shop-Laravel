@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Tambah Menu</h5>

        <form method="POST" action="{{ route('manager.menus.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(this, 'imagePreview')">
                <img id="imagePreview" class="image-preview mt-2" src="#" alt="Preview" style="display: none;">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="mb-3 form-check">
                <input type="hidden" name="is_available" value="0">
                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" checked>
                <label class="form-check-label" for="is_available">Tersedia</label>
            </div>
            <button type="submit" class="btn btn-coffee">Ajukan</button>
            <a href="{{ route('manager.menus.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
