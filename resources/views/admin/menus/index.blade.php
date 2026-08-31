@extends('layouts.app')

@section('title', 'Daftar Menu Admin')

@section('content')
<div class="admin-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-cup-hot"></i>
            </div>
            <h2>Daftar Menu</h2>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="btn-primary-solid">
            <i class="bi bi-plus-lg"></i>
            Tambah Menu
        </a>
    </div>

    <div class="menu-table-card">
        <div class="menu-toolbar">
            <form method="GET" action="{{ route('admin.menus.index') }}" class="menu-search-form">
                <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="{{ $search }}">
                <button type="submit" class="btn-primary-solid">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://via.placeholder.com/100' }}" alt="{{ $menu->name }}" class="menu-thumb">
                            </td>
                            <td><strong>{{ $menu->name }}</strong></td>
                            <td>{{ $menu->category->name ?? '-' }}</td>
                            <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>
                                @if($menu->stock > 0)
                                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1">
                                        <i class="bi bi-box-seam me-1"></i>{{ $menu->stock }}
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">
                                        <i class="bi bi-x-circle me-1"></i>Habis (0)
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $menu->status }}">
                                    {{ ucfirst($menu->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="text-coffee mb-2">Tidak ada data</h5>
                                    <p class="text-muted-custom">Belum ada menu yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($menus->hasPages())
            <div class="pagination-container d-flex justify-content-center mt-4">
                {{ $menus->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
