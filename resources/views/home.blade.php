@extends('layouts.app')

@section('title', 'Coffee Shop - Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section mb-5">
    <div class="row align-items-center min-vh-60" style="min-height: 60vh;">
        <div class="col-lg-6">
            <h1 class="display-3 fw-bold text-brown mb-3">Selamat Datang di<br>Coffee Shop</h1>
            <p class="lead text-muted-custom mb-4">Nikmati kopi terbaik dengan cita rasa autentik dan suasana yang nyaman. Dipilih dari biji kopi pilihan dan disiapkan oleh barista profesional.</p>
            <div class="d-flex gap-3">
                <a href="#menu-section" class="btn btn-coffee btn-lg">Lihat Menu</a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-coffee btn-lg">Daftar Sekarang</a>
                @endguest
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{ asset('images/default-menu.jpg') }}" alt="Coffee Shop" class="img-fluid rounded-3 shadow-lg" style="max-height: 400px; object-fit: cover;">
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section mb-5">
    <div class="text-center mb-4">
        <h2 class="h2 text-brown">Kategori Menu</h2>
        <p class="text-muted-custom">Pilih kategori favoritmu</p>
    </div>

    <div class="row g-4">
        @foreach($categories as $category)
            <div class="col-md-4 col-lg-2">
                <a href="{{ route('user.menus.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                    <div class="card text-center h-100 menu-card">
                        <div class="card-body">
                            <div class="display-4 mb-2">☕</div>
                            <h6 class="card-title text-brown">{{ $category->name }}</h6>
                            <p class="card-text small text-muted-custom">{{ $category->description ?? 'Menu ' . $category->name }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</section>

<!-- Featured Menus Section -->
<section id="menu-section" class="menus-section mb-5">
    <div class="text-center mb-4">
        <h2 class="h2 text-brown">Menu Populer</h2>
        <p class="text-muted-custom">Pilihan terbaik dari menu kami</p>
    </div>

    @if($menus->count() > 0)
        <div class="row g-4">
            @foreach($menus as $menu)
                <div class="col-md-6 col-lg-4">
                    <div class="card menu-card h-100">
                        <img src="{{ $menu->image_url }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-coffee-light mb-2">{{ $menu->category->name ?? 'Menu' }}</span>
                                    <h5 class="card-title text-brown mb-1">{{ $menu->name }}</h5>
                                </div>
                                <span class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                            </div>
                            <p class="card-text small text-muted-custom flex-grow-1">{{ Str::limit($menu->description, 80) }}</p>
                            <div class="mt-auto">
                                @auth
                                    @if(auth()->user()->role === 'user')
                                        <form action="{{ route('user.cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-coffee w-100">
                                                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('user.menus.show', $menu) }}" class="btn btn-outline-coffee w-100">Lihat Detail</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-coffee w-100">
                                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('user.menus.index') }}" class="btn btn-outline-coffee">Lihat Semua Menu</a>
        </div>
    @else
        <div class="alert alert-info text-center">
            <p class="mb-0">Belum ada menu yang tersedia saat ini. Silakan cek kembali nanti.</p>
        </div>
    @endif
</section>

<!-- About Section -->
<section class="about-section mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <img src="{{ asset('images/default-menu.jpg') }}" alt="Coffee Shop" class="img-fluid rounded-3 shadow" style="max-height: 350px; object-fit: cover;">
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
            <h2 class="h2 text-brown mb-3">Tentang Coffee Shop</h2>
            <p class="text-muted-custom">
                Coffee Shop adalah destinasi bagi pecinta kopi yang mengutamakan kualitas dan cita rasa autentik.
                Kami menggunakan biji kopi pilihan dari petani lokal Indonesia yang disangrai dengan presisi untuk menghasilkan
                karakter rasa yang konsisten dan memorable.
            </p>
            <p class="text-muted-custom">
                Didukung oleh barista profesional dan suasana ruang yang nyaman, setiap kunjungan Anda di Coffee Shop
                adalah pengalaman menikmati kopi yang lebih hangat dan personal.
            </p>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="features-section mb-5">
    <div class="text-center mb-4">
        <h2 class="h2 text-brown">Keunggulan Kami</h2>
        <p class="text-muted-custom">Mengapa memilih Coffee Shop?</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="display-4 text-coffee mb-3">🌱</div>
                    <h5 class="card-title text-brown">Biji Kopi Pilihan</h5>
                    <p class="card-text small text-muted-custom">Kami hanya menggunakan biji kopi terbaik dari petani lokal Indonesia.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="display-4 text-coffee mb-3">👨‍🍳</div>
                    <h5 class="card-title text-brown">Barista Profesional</h5>
                    <p class="card-text small text-muted-custom">Setiap secangkir disiapkan oleh barista berpengalaman dan berdedikasi.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="display-4 text-coffee mb-3">🚚</div>
                    <h5 class="card-title text-brown">Pengiriman Cepat</h5>
                    <p class="card-text small text-muted-custom">Pesanan Anda akan segera diproses dan dikirim dengan cepat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
