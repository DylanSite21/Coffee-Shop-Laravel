@extends('layouts.app')

@section('title', 'Daftar Users')

@section('content')
<div class="admin-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-people"></i>
            </div>
            <h2>Daftar Users</h2>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary-solid">
            <i class="bi bi-plus-lg"></i>
            Tambah User
        </a>
    </div>

    <div class="menu-table-card">
        <div class="menu-toolbar">
            <form method="GET" action="{{ route('admin.users.index') }}" class="menu-search-form">
                <input type="text" name="search" class="form-control" placeholder="Cari user..." value="{{ $search }}">
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
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="user-name">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge role-{{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h5 class="text-coffee mb-2">Tidak ada data</h5>
                                    <p class="text-muted-custom">Belum ada user yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pagination-container">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
