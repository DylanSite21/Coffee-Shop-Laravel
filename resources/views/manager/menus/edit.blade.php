@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Edit Menu</h5>

        <form method="POST" action="{{ route('manager.menus.update', $menu) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $menu->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description', $menu->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $menu->price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(this, 'imagePreview')">
                @if($menu->image)
                    <img src="{{ $menu->image_url }}" class="mt-2" style="max-height: 200px; border-radius: 0.5rem;">
                @endif
                <img id="imagePreview" class="image-preview mt-2" src="#" alt="Preview" style="display: none;">
            </div>
            <!-- <div class="mb-3">
                <label class="form-label">Status Menu</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="pending" {{ old('status', $menu->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                    <option value="approved" {{ old('status', $menu->status) == 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                    <option value="rejected" {{ old('status', $menu->status) == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> -->
            <div class="mb-3 form-check">
                <input type="hidden" name="is_available" value="0">
                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" {{ $menu->is_available ? 'checked' : '' }}>
                <label class="form-check-label" for="is_available">Tersedia</label>
            </div>
            <button type="submit" class="btn btn-coffee">Update</button>
            <a href="{{ route('manager.menus.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
