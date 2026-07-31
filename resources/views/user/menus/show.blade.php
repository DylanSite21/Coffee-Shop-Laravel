@extends('layouts.app')

@section('title', $menu->name . ' - Coffee Shop')

@section('content')
<section class="detail-menu-section py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" data-aos="fade-up">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.menus.index') }}" class="text-decoration-none">Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $menu->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="{{ $menu->image_url }}" 
                         alt="{{ $menu->name }}" 
                         class="img-fluid rounded-4 shadow-lg w-100"
                         style="max-height: 500px; object-fit: cover;">
                </div>
            </div>

            <!-- Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <span class="badge bg-light text-dark mb-2 px-3 py-2">
                    {{ $menu->category->name ?? 'Menu' }}
                </span>
                <h1 class="display-5 fw-bold">{{ $menu->name }}</h1>
                <div class="d-flex align-items-center gap-3 mt-2">
                    <span class="text-warning fs-4">★★★★★</span>
                    <span class="text-muted">(4.9 · 120+ reviews)</span>
                </div>
                <h3 class="text-warning fw-bold mt-3">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </h3>

                <hr>

                <h5 class="fw-bold">Description</h5>
                <p class="text-muted">{{ $menu->description ?? 'Delicious coffee crafted with love by our expert baristas.' }}</p>

                <div class="row g-3 mt-3">
                    <div class="col-6">
                        <div class="bg-light p-3 rounded-3 text-center">
                            <small class="text-muted d-block">Category</small>
                            <span class="fw-bold">{{ $menu->category->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-3 rounded-3 text-center">
                            <small class="text-muted d-block">Status</small>
                            <span class="fw-bold text-success">✅ Available</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    @if(Auth::check() && Auth::user()->role === 'user')
                        <form action="{{ route('user.cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <div class="row g-3">
                                <div class="col-4">
                                    <input type="number" name="quantity" value="1" min="1" max="10" 
                                           class="form-control form-control-lg text-center">
                                </div>
                                <div class="col-8">
                                    <button type="submit" class="btn btn-warning btn-lg w-100">
                                        🛒 Add to Cart - Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100">
                            🔒 Login to Order
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Menus -->
        @if($relatedMenus->count() > 0)
            <div class="mt-5">
                <h3 class="fw-bold mb-4">🍽️ You Might Also Like</h3>
                <div class="row g-4">
                    @foreach($relatedMenus as $related)
                        <div class="col-md-3">
                            <div class="card h-100 shadow-sm hover-card">
                                <img src="{{ $related->image_url }}" 
                                     class="card-img-top" 
                                     alt="{{ $related->name }}"
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $related->name }}</h6>
                                    <p class="text-warning fw-bold">
                                        Rp {{ number_format($related->price, 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('user.menus.show', $related) }}" class="btn btn-outline-warning w-100 btn-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
</script>
@endpush