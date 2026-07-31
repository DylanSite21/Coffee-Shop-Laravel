@extends('layouts.app')

@section('title', 'Explore Menu - Coffee Shop')

@section('content')
<section class="explore-menu-section py-5">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2">Explore</span>
            <h1 class="display-4 fw-bold mt-2">Our <span class="text-warning">Menu</span></h1>
            <p class="text-muted">Discover your favorite coffee from our curated selection</p>
        </div>

        <!-- Filter & Search -->
        <div class="row g-3 mb-4" data-aos="fade-up">
            <div class="col-md-4">
                <form action="{{ route('user.menus.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-lg" 
                           placeholder="🔍 Search menu..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-warning btn-lg px-4">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select form-select-lg" onchange="this.form.submit()" form="filter-form">
                    <option value="">📂 All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->icon ?? '☕' }} {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select form-select-lg" onchange="this.form.submit()" form="filter-form">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>🔄 Terbaru</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>💰 Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>💰 Termahal</option>
                    <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>⭐ Terpopuler</option>
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('user.menus.index') }}" class="btn btn-outline-dark btn-lg w-100">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </div>

        <!-- Hidden form untuk filter -->
        <form id="filter-form" action="{{ route('user.menus.index') }}" method="GET" class="d-none">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        </form>

        <!-- Result Count -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted mb-0">
                Showing <strong>{{ $menus->firstItem() ?? 0 }}</strong> - <strong>{{ $menus->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $menus->total() }}</strong> menus
            </p>
        </div>

        <!-- Menu Grid -->
        @if($menus->count() > 0)
            <div class="row g-4">
                @foreach($menus as $menu)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="position-relative">
                                <img src="{{ $menu->image_url }}" 
                                     class="card-img-top" 
                                     alt="{{ $menu->name }}"
                                     style="height: 220px; object-fit: cover;">
                                <span class="badge bg-light text-dark position-absolute top-0 start-0 m-3 px-3 py-2">
                                    {{ $menu->category->name ?? 'Menu' }}
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-bold">{{ $menu->name }}</h5>
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($menu->description ?? 'Delicious coffee crafted with love', 60) }}
                                        </p>
                                    </div>
                                    <span class="text-warning fw-bold fs-5">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('user.menus.show', $menu) }}" class="btn btn-outline-warning flex-grow-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    @if(Auth::check() && Auth::user()->role === 'user')
                                        <form action="{{ route('user.cart.store') }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-warning w-100">
                                                🛒
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning flex-grow-1">
                                            🔒
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                {{ $menus->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <span class="display-1 d-block">☕</span>
                <h4>No menus found</h4>
                <p class="text-muted">Try adjusting your search or filter</p>
                <a href="{{ route('user.menus.index') }}" class="btn btn-warning mt-3">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    }
    .pagination {
        gap: 5px;
    }
    .pagination .page-link {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 10px 16px;
        color: #1a0f0a;
    }
    .pagination .page-link:hover {
        background: #d4a24e;
        color: white;
        border-color: #d4a24e;
    }
    .pagination .active .page-link {
        background: #d4a24e;
        border-color: #d4a24e;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 80
    });

    // Auto submit form when filter changes
    document.querySelectorAll('select').forEach(el => {
        el.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });
</script>
@endpush