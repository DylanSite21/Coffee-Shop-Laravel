@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Kategori</h5>

            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" onchange="previewImage(this, 'imagePreview')">
                    @if ($category->image)
                        <img src="{{ $category->image_url }}" class="mt-2"
                            style="max-height: 200px; border-radius: 0.5rem;">
                    @endif
                    <img id="imagePreview" class="image-preview mt-2" src="#" alt="Preview" style="display: none;">
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                        {{ $category->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <button type="submit" class="btn btn-coffee">Update</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
