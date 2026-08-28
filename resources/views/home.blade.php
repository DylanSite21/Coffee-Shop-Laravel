@extends('layouts.app')

@section('title', 'Kopi Nusantara — Kedai Kopi Premium Indonesia')

@section('content')

    {{-- ================================================================
     HERO SECTION
     ================================================================ --}}
    <section class="hero-section py-5 px-5 fade-in">
        <div class="row align-items-center g-5" style="min-height:82vh;">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="hero-badge fade-in-up">
                    <span>✨</span> Biji Kopi Pilihan Nusantara
                </div>

                <h1 class="hero-title fade-in-up delay-1">
                    Nikmati Kopi<br>
                    <span class="accent">Terbaik</span><br>
                    Indonesia
                </h1>

                <p class="hero-subtitle fade-in-up delay-2">
                    Dari pegunungan Flores, Toraja, hingga Aceh — setiap tegukan menceritakan
                    kisah petani kopi dan tradisi penyeduhan yang telah turun-temurun.
                    Hadir dalam suasana hangat yang memanjakan.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4 fade-in-up delay-3">
                    <a href="#menu-section" class="btn btn-coffee btn-lg px-4">
                        <i class="bi bi-cup-hot me-2"></i>Lihat Menu
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-coffee btn-lg px-4">
                            Daftar Gratis
                        </a>
                    @endguest
                </div>

                {{-- Stats --}}
                <div class="d-flex gap-4 pt-3 fade-in-up delay-4" style="border-top:1px solid #DEC9AA;">
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:800;color:#3E1F0D;">
                            50+</div>
                        <div style="font-size:0.8rem;color:#6B4C3B;font-weight:500;">Varian Menu</div>
                    </div>
                    <div style="width:1px;background:#DEC9AA;"></div>
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:800;color:#3E1F0D;">
                            1.2K+</div>
                        <div style="font-size:0.8rem;color:#6B4C3B;font-weight:500;">Pelanggan Puas</div>
                    </div>
                    <div style="width:1px;background:#DEC9AA;"></div>
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:800;color:#3E1F0D;">⭐
                            4.9</div>
                        <div style="font-size:0.8rem;color:#6B4C3B;font-weight:500;">Rating Rata-rata</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 order-1 order-lg-2 text-center fade-in delay-1">
                <div class="hero-image-wrap mx-auto" style="max-width:520px;position:relative;">
                    <img src="{{ asset('images/hero-bg.jpg') }}" alt="Kopi Nusantara — Suasana Kedai"
                        class="img-fluid w-100" style="height:460px;object-fit:cover;border-radius:1.5rem;">

                    {{-- Floating Pill --}}
                    <div class="hero-stat-pill pill-bottom-left d-none d-lg-block">
                        <div class="d-flex align-items-center gap-2">
                            <div style="font-size:1.75rem;">☕</div>
                            <div>
                                <div
                                    style="font-size:0.7rem;color:#6B4C3B;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
                                    Terseduh Hari Ini</div>
                                <div
                                    style="font-size:1.1rem;font-weight:800;color:#3E1F0D;font-family:'Playfair Display',serif;">
                                    247 Cangkir</div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-stat-pill pill-top-right d-none d-lg-block">
                        <div class="d-flex align-items-center gap-2">
                            <div style="font-size:1.5rem;">🌱</div>
                            <div>
                                <div
                                    style="font-size:0.7rem;color:#6B4C3B;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
                                    Biji Kopi Lokal</div>
                                <div style="font-size:1rem;font-weight:700;color:#3E1F0D;">100% Nusantara</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     CATEGORIES SECTION
     ================================================================ --}}
    <section class="categories-section py-5 mb-2">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Menu</h2>
            <p class="text-muted-custom mt-3">Temukan minuman dan camilan favoritmu</p>
        </div>

        @php
            $categoryIcons = [
                'coffee' => '☕',
                'non-coffee' => '🍵',
                'pastry' => '🥐',
                'snacks' => '🍟',
                'cookies' => '🍪',
            ];
        @endphp

        <div class="row g-3 justify-content-center">
            @foreach ($categories as $category)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('user.menus.index', ['category' => $category->slug]) }}"
                        class="card category-card text-decoration-none d-block" style="background-color:#F5E8D4;">
                        <span class="category-icon">
                            {{ $categoryIcons[$category->slug] ?? '🍽️' }}
                        </span>
                        <h6 class="card-title mb-1" style="font-size:0.95rem;">{{ $category->name }}</h6>
                        <p class="mb-0" style="font-size:0.75rem;color:#6B4C3B;">
                            {{ $category->description ?? '' }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================================================================
     FEATURED MENUS SECTION
     ================================================================ --}}
    <section id="menu-section" class="menus-section py-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Menu Populer</h2>
            <p class="text-muted-custom mt-3">Pilihan terfavorit pelanggan setia Kopi Nusantara</p>
        </div>

        @if ($menus->count() > 0)
            <div class="row g-4">
                @foreach ($menus as $menu)
                    <div class="col-md-6 col-lg-4 fade-in-up">
                        <div class="card menu-card h-100">
                            <div style="overflow:hidden;border-radius:0.75rem 0.75rem 0 0;">
                                <img src="{{ $menu->image_url }}" class="card-img-top" alt="{{ $menu->name }}"
                                    style="height:210px;object-fit:cover;transition:transform 0.4s ease;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge mb-2"
                                            style="background:rgba(192,139,92,0.15);color:#6B3A2A;border:1px solid rgba(192,139,92,0.3);">
                                            {{ $menu->category->name ?? 'Menu' }}
                                        </span>
                                        <h5 class="card-title mb-0">{{ $menu->name }}</h5>
                                    </div>
                                    <div class="menu-price text-end ms-2">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <p class="card-text flex-grow-1">{{ Str::limit($menu->description, 90) }}</p>
                                <div class="mt-auto pt-2">
                                    @auth
                                        @if (auth()->user()->role === 'user')
                                            <form action="{{ route('user.cart.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-coffee w-100">
                                                    <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('user.menus.show', $menu) }}"
                                                class="btn btn-outline-coffee w-100">
                                                Lihat Detail
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-coffee w-100">
                                            <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('user.menus.index') }}" class="btn btn-outline-coffee btn-lg px-5">
                    Lihat Semua Menu <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <div style="font-size:3rem;margin-bottom:1rem;">☕</div>
                <p class="text-muted-custom">Belum ada menu yang tersedia saat ini. Silakan cek kembali nanti.</p>
            </div>
        @endif
    </section>

    {{-- ================================================================
     ABOUT SECTION
     ================================================================ --}}
    <section id="tentang" class="about-section py-5"
        style="background:linear-gradient(135deg,#F5E8D4 0%,#FDF6ED 100%);border-radius:1.5rem;margin-bottom:2rem;padding-left:2rem;padding-right:2rem;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div style="border-radius:1.25rem;overflow:hidden;box-shadow:0 8px 40px rgba(62,31,13,0.18);">
                    <img src="{{ asset('images/about-coffee.jpg') }}" alt="Biji Kopi Pilihan Kopi Nusantara"
                        class="img-fluid w-100" style="height:380px;object-fit:cover;">
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <span
                    style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#C08B5C;">
                    Tentang Kami
                </span>
                <h2 class="section-title text-start mt-2 mb-0" style="padding-bottom:0.5rem;">
                    Cerita di Balik<br>Setiap Cangkir
                </h2>
                <div
                    style="width:50px;height:3px;background:linear-gradient(90deg,#C08B5C,#D4A855);border-radius:99px;margin:0.75rem 0 1.25rem;">
                </div>
                <p class="text-muted-custom mb-3">
                    Kopi Nusantara lahir dari kecintaan mendalam terhadap kopi Indonesia. Kami percaya bahwa Indonesia
                    memiliki biji kopi terbaik di dunia — dari Gayo Aceh yang floral, Toraja Sulawesi yang earthy,
                    hingga Flores yang bittersweet.
                </p>
                <p class="text-muted-custom mb-4">
                    Setiap biji dipilih langsung dari petani lokal terpercaya, disangrai dengan presisi oleh roaster
                    berpengalaman, dan disajikan oleh barista profesional yang mencintai pekerjaannya.
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3" style="background:#FDF6ED;border-radius:0.75rem;border:1px solid #DEC9AA;">
                            <div style="font-size:1.4rem;margin-bottom:0.25rem;">🌿</div>
                            <div style="font-weight:700;font-size:0.875rem;color:#3E1F0D;">100% Lokal</div>
                            <div style="font-size:0.75rem;color:#6B4C3B;">Biji kopi petani Indonesia</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3" style="background:#FDF6ED;border-radius:0.75rem;border:1px solid #DEC9AA;">
                            <div style="font-size:1.4rem;margin-bottom:0.25rem;">👨‍🍳</div>
                            <div style="font-weight:700;font-size:0.875rem;color:#3E1F0D;">Barista Expert</div>
                            <div style="font-size:0.75rem;color:#6B4C3B;">Bersertifikat & berpengalaman</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     KEUNGGULAN SECTION
     ================================================================ --}}
    <section class="features-section py-5 mb-2">
        <div class="text-center mb-5">
            <h2 class="section-title">Mengapa Kopi Nusantara?</h2>
            <p class="text-muted-custom mt-3">Lebih dari sekedar kopi — sebuah pengalaman</p>
        </div>

        <div class="row g-4">
            @php
                $features = [
                    [
                        'icon' => '🌱',
                        'title' => 'Biji Pilihan Petani Lokal',
                        'desc' =>
                            'Kami berkolaborasi langsung dengan petani kopi dari Aceh, Toraja, Flores, dan daerah lainnya untuk mendapatkan biji terbaik setiap musim panen.',
                    ],
                    [
                        'icon' => '👨‍🍳',
                        'title' => 'Barista Profesional',
                        'desc' =>
                            'Tim barista kami bersertifikat internasional dengan pengalaman bertahun-tahun. Setiap cangkir dibuat dengan teknik dan perhatian penuh.',
                    ],
                    [
                        'icon' => '⚡',
                        'title' => 'Pesanan Cepat & Mudah',
                        'desc' =>
                            'Pesan melalui platform kami, bayar dengan mudah, dan nikmati pesananmu. Proses pembuatan dimonitor secara real-time.',
                    ],
                    [
                        'icon' => '🏆',
                        'title' => 'Kualitas Terjamin',
                        'desc' =>
                            'Seluruh menu melewati proses quality control yang ketat. Kepuasan Anda adalah prioritas utama kami sejak hari pertama.',
                    ],
                    [
                        'icon' => '🌙',
                        'title' => 'Suasana Nyaman',
                        'desc' =>
                            'Desain interior hangat dengan pencahayaan yang nyaman, cocok untuk bekerja, bertemu teman, atau sekadar menikmati waktu sendiri.',
                    ],
                    [
                        'icon' => '💝',
                        'title' => 'Program Loyalitas',
                        'desc' =>
                            'Dapatkan poin setiap pembelian dan tukarkan dengan minuman gratis, diskon spesial, dan berbagai hadiah menarik lainnya.',
                    ],
                ];
            @endphp
            @foreach ($features as $i => $feat)
                <div class="col-md-6 col-lg-4 fade-in-up delay-{{ ($i % 4) + 1 }}">
                    <div class="card h-100"
                        style="border:1px solid #EDD9BC;background:linear-gradient(135deg,#FDF6ED 0%,#F5E8D4 100%);">
                        <div class="card-body p-4">
                            <div style="font-size:2.25rem;margin-bottom:0.875rem;">{{ $feat['icon'] }}</div>
                            <h5 class="card-title mb-2">{{ $feat['title'] }}</h5>
                            <p class="card-text" style="font-size:0.875rem;color:#6B4C3B;line-height:1.7;">
                                {{ $feat['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================================================================
     TESTIMONIALS SECTION
     ================================================================ --}}
    <section class="testimonials-section py-5 mb-2"
        style="background:linear-gradient(135deg,#3E1F0D 0%,#6B3A2A 100%);border-radius:1.5rem;padding-left:2rem;padding-right:2rem;">
        <div class="text-center mb-5">
            <h2 class="section-title" style="color:#FDF6ED;">Yang Mereka Katakan</h2>
            <p style="color:#C8A882;margin-top:0.75rem;">Ulasan nyata dari pelanggan setia kami</p>
        </div>

        <div class="row g-4">
            @php
                $testimonials = [
                    [
                        'name' => 'Rania Kusuma',
                        'role' => 'Mahasiswi UI',
                        'rating' => 5,
                        'text' =>
                            'Cappuccino di sini beneran beda! Foam-nya lembut, rasanya pas banget antara pahit dan manisnya. Jadi langganan rutin sebelum kuliah.',
                        'avatar' => 'R',
                    ],
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'Software Engineer',
                        'rating' => 5,
                        'text' =>
                            'Tempatnya cozy banget buat kerja. WiFi kencang, kopi enak, dan staff-nya ramah. Caramel Macchiato-nya jadi andalan saya setiap hari!',
                        'avatar' => 'B',
                    ],
                    [
                        'name' => 'Dira Anggraini',
                        'role' => 'Content Creator',
                        'rating' => 5,
                        'text' =>
                            'Matcha Latte di sini mengalahkan banyak coffee shop lain yang pernah saya coba. Worth it banget! Pasti balik lagi bawa teman-teman.',
                        'avatar' => 'D',
                    ],
                ];
            @endphp
            @foreach ($testimonials as $testi)
                <div class="col-md-4">
                    <div
                        style="background:rgba(253,246,237,0.08);border:1px solid rgba(255,255,255,0.1);border-radius:1rem;padding:1.75rem;height:100%;backdrop-filter:blur(10px);">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                style="width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#C08B5C,#D4A855);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:#3E1F0D;flex-shrink:0;">
                                {{ $testi['avatar'] }}
                            </div>
                            <div>
                                <div style="font-weight:700;color:#FDF6ED;font-size:0.9rem;">{{ $testi['name'] }}</div>
                                <div style="font-size:0.75rem;color:#C08B5C;">{{ $testi['role'] }}</div>
                            </div>
                            <div class="ms-auto" style="font-size:0.85rem;color:#D4A855;letter-spacing:1px;">
                                {{ str_repeat('⭐', $testi['rating']) }}
                            </div>
                        </div>
                        <p style="color:#EDD9BC;font-size:0.875rem;line-height:1.75;font-style:italic;margin:0;">
                            "{{ $testi['text'] }}"
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================================================================
     CTA SECTION
     ================================================================ --}}
    @guest
        <section class="cta-section py-5 text-center">
            <div style="max-width:560px;margin:auto;">
                <div style="font-size:3rem;margin-bottom:0.75rem;">☕</div>
                <h2
                    style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:#3E1F0D;margin-bottom:0.75rem;">
                    Siap Memesan?
                </h2>
                <p style="color:#6B4C3B;margin-bottom:2rem;font-size:1rem;">
                    Buat akun sekarang dan nikmati pengalaman memesan kopi premium yang mudah, cepat, dan menyenangkan.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-coffee btn-lg px-5">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-coffee btn-lg px-5">
                        Sudah Punya Akun? Masuk
                    </a>
                </div>
            </div>
        </section>
    @endguest

@endsection
