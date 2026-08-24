@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <form method="GET" action="{{ route('user.menus.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari menu..."
                    value="{{ $search }}">
                <button type="submit" class="btn btn-coffee">Cari</button>
            </form>
        </div>
        <div class="col-md-8">
            <select class="form-select" onchange="location = '{{ route('user.menus.index') }}?category=' + this.value;">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" {{ $categorySlug == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        @forelse($menus as $menu)
            <x-menu-card :menu="$menu" />
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada menu tersedia.
                </div>
            </div>
        @endforelse
    </div>


    <div class="d-flex justify-content-center mt-4">
        {{ $menus->links() }}
    </div>
@endsection
