@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Daftar Kategori</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-coffee">Tambah Kategori</a>
            </div>

            <div class="mb-3">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari kategori..."
                        value="{{ $search }}" style="max-width:250px;">
                    <button type="submit" class="btn btn-coffee">Cari</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($category->image)
                                        @if (file_exists(public_path('storage/' . $category->image)))
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="menu-thumb">
                                        @elseif (file_exists(public_path('images/' . $menu->image)))
                                            <img src="{{ asset('images/' . $category->image) }}" alt="{{ $category->name }}"
                                                class="menu-thumb">
                                        @endif
                                    @else
                                        <div class="menu-thumb">
                                            <i class="bi bi-cup-hot"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
