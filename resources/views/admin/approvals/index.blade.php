@extends('layouts.app')

@section('title', 'Approval Menu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Daftar Menu Menunggu Approval</h5>

        <div class="mb-3">
            <form method="GET" action="{{ route('admin.approvals.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari menu..." value="{{ $search }}">
                <button type="submit" class="btn btn-coffee">Cari</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('admin.approvals.approve', $menu) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.approvals.reject', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin tolak?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada menu menunggu approval.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $menus->links() }}
    </div>
</div>
@endsection
