@extends('layouts.app')

@section('title', 'Pengajuan Menu')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Daftar Pengajuan Menu</h5>
            <a href="{{ route('manager.menus.create') }}" class="btn btn-coffee">Tambah Menu</a>
        </div>

        <div class="mb-3">
            <form method="GET" action="{{ route('manager.menus.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari menu..." value="{{ $search }}">
                <button type="submit" class="btn btn-coffee">Cari</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://via.placeholder.com/100' }}" alt="{{ $menu->name }}" class="img-fluid" style="max-width: 100px;"></td>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($menu->status) }}</td>
                        <td>
                            <a href="{{ route('manager.menus.edit', $menu) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('manager.menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $menus->links() }}
    </div>
</div>
@endsection
