@extends('layouts.app')

@section('title', 'Approval Menu')

@section('content')
<div class="admin-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h2>Approval Menu</h2>
        </div>
    </div>

    <div class="menu-table-card">
        <div class="menu-toolbar">
            <form method="GET" action="{{ route('admin.approvals.index') }}" class="menu-search-form">
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
                            <td><strong>{{ $menu->name }}</strong></td>
                            <td>{{ $menu->category->name ?? '-' }}</td>
                            <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>
                                <div class="action-btns">
                                    <form action="{{ route('admin.approvals.approve', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui menu ini?')">
                                        @csrf
                                        <button type="submit" class="approve-btn" title="Approve">
                                            <i class="bi bi-check-lg"></i>
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.approvals.reject', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin tolak?')">
                                        @csrf
                                        <button type="submit" class="reject-btn" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-check2-all"></i>
                                    </div>
                                    <h5 class="text-coffee mb-2">Tidak ada menunggu approval</h5>
                                    <p class="text-muted-custom">Semua menu sudah diproses. Bagus!</p>
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
