@extends('layouts.app')

@section('title', 'Coffee Shop - Home')

@section('content')
<!-- ============================================ -->
<!-- HERO SECTION -->
<!-- ============================================ -->
<section class="hero-section">
    <div class="container py-5">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                    ☕ Premium Coffee Since 2020
                </span>
                <h1 class="display-1 fw-bold text-dark mb-3">
                    Start Your Day<br>
                    With <span class="text-warning">Perfect</span> Coffee
                </h1>
                <p class="lead text-muted mb-4">
                    Experience the art of specialty coffee, crafted with passion 
                    and precision by our master baristas.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#menu-section" class="btn btn-warning btn-lg px-5">
                        Explore Menu →
                    </a>
                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-lg px-5">
                                Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'manager')
                            <a href="{{ route('manager.dashboard') }}" class="btn btn-outline-dark btn-lg px-5">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.menus.index') }}" class="btn btn-outline-dark btn-lg px-5">
                                View Menu
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg px-5">
                            Join Now
                        </a>
                    @endif
                </div>
                <div class="row mt-5 pt-3">
                    <div class="col-4">
                        <h3 class="text-warning fw-bold">{{ $totalMenus }}+</h3>
                        <small class="text-muted">Menu Items</small>
                    </div>
                    <div class="col-4">
                        <h3 class="text-warning fw-bold">4.9</h3>
                        <small class="text-muted">⭐ Rating</small>
                    </div>
                    <div class="col-4">
                        <h3 class="text-warning fw-bold">{{ $totalCategories }}</h3>
                        <small class="text-muted">Categories</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="coffee-display">
                    <span class="display-1">☕</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- CATEGORIES SECTION -->
<!-- ============================================ -->
<section class="categories-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2">Categories</span>
            <h2 class="display-4 fw-bold mt-2">Explore Our <span class="text-warning">Menu</span></h2>
            <p class="text-muted">Discover your favorite coffee from our curated selection</p>
        </div>

        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                    <a href="{{ route('user.menus.index', ['category' => $category->slug]) }}" 
                       class="text-decoration-none">
                        <div class="card text-center h-100 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="display-4 mb-2">{{ $category->icon ?? '☕' }}</div>
                                <h6 class="fw-bold">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->menus_count ?? 0 }} items</small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No categories available</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- POPULAR MENU SECTION -->
<!-- ============================================ -->
<section id="menu-section" class="menu-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2">Popular</span>
            <h2 class="display-4 fw-bold mt-2">Signature <span class="text-warning">Menu</span></h2>
            <p class="text-muted">Our most loved coffee creations</p>
        </div>

        @if($menus->count() > 0)
            <div class="row g-4">
                @foreach($menus as $menu)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="position-relative">
                                <img src="{{ $menu->image_url }}" 
                                     class="card-img-top" 
                                     alt="{{ $menu->name }}"
                                     style="height: 220px; object-fit: cover;">
                                @if($loop->index < 3)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">
                                        🔥 Popular
                                    </span>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge bg-light text-dark mb-2">
                                            {{ $menu->category->name ?? 'Menu' }}
                                        </span>
                                        <h5 class="card-title fw-bold">{{ $menu->name }}</h5>
                                    </div>
                                    <span class="text-warning fw-bold fs-5">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <p class="card-text text-muted small">
                                    {{ Str::limit($menu->description ?? 'Delicious coffee crafted with love', 60) }}
                                </p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                @if(Auth::check())
                                    @if(Auth::user()->role === 'user')
                                        <form action="{{ route('user.cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-warning w-100">
                                                🛒 Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('user.menus.show', $menu) }}" class="btn btn-outline-dark w-100">
                                            View Details
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-warning w-100">
                                        🔒 Login to Order
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('user.menus.index') }}" class="btn btn-outline-warning btn-lg px-5">
                    View All Menu →
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <span class="display-1 d-block">☕</span>
                <h4>No menus available</h4>
                <p class="text-muted">Check back later for our delicious offerings</p>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- ABOUT SECTION -->
<!-- ============================================ -->
<section class="about-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&h=400&fit=crop" 
                     class="img-fluid rounded-4 shadow" 
                     alt="About Us">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="badge bg-warning text-dark px-3 py-2">About Us</span>
                <h2 class="display-4 fw-bold mt-2">More Than Just <span class="text-warning">Coffee</span></h2>
                <p class="lead text-muted">
                    We're passionate about creating the perfect coffee experience, from bean to cup.
                </p>
                <p class="text-muted">
                    Every coffee bean is carefully selected from local Indonesian farmers, 
                    roasted to perfection, and brewed with precision by our skilled baristas.
                </p>
                <div class="row g-3 mt-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-warning fs-4">✓</span>
                            <span>Premium Beans</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-warning fs-4">✓</span>
                            <span>Expert Baristas</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-warning fs-4">✓</span>
                            <span>Cozy Atmosphere</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-warning fs-4">✓</span>
                            <span>Best Prices</span>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-warning mt-4 px-5">Learn More →</a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- WHY US SECTION -->
<!-- ============================================ -->
<section class="why-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2">Why Us</span>
            <h2 class="display-4 fw-bold mt-2">Why Choose <span class="text-warning">Us</span></h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card text-center h-100 shadow-sm hover-card p-4">
                    <div class="display-3 mb-3">🌱</div>
                    <h5 class="fw-bold">Premium Quality</h5>
                    <p class="text-muted">Only the finest coffee beans from local Indonesian farmers.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center h-100 shadow-sm hover-card p-4">
                    <div class="display-3 mb-3">👨‍🍳</div>
                    <h5 class="fw-bold">Expert Baristas</h5>
                    <p class="text-muted">Skilled baristas with years of experience and passion.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card text-center h-100 shadow-sm hover-card p-4">
                    <div class="display-3 mb-3">🚚</div>
                    <h5 class="fw-bold">Fast Delivery</h5>
                    <p class="text-muted">Quick and reliable delivery service, fresh and hot.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- TESTIMONIALS SECTION -->
<!-- ============================================ -->
<section class="testimonial-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2">Testimonials</span>
            <h2 class="display-4 fw-bold mt-2">What Our <span class="text-warning">Customers</span> Say</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card shadow-sm hover-card p-4">
                    <div class="text-warning fs-5 mb-2">⭐⭐⭐⭐⭐</div>
                    <p class="text-muted fst-italic">"The best coffee in town! Perfect for working and the staff are incredibly friendly."</p>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 44px; height: 44px; font-weight: 700;">A</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Andi Pratama</h6>
                            <small class="text-muted">Freelancer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow-sm hover-card p-4">
                    <div class="text-warning fs-5 mb-2">⭐⭐⭐⭐⭐</div>
                    <p class="text-muted fst-italic">"I love their matcha latte! The quality is consistently excellent and the service is top-notch."</p>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 44px; height: 44px; font-weight: 700;">S</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Siti Rahma</h6>
                            <small class="text-muted">Student</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card shadow-sm hover-card p-4">
                    <div class="text-warning fs-5 mb-2">⭐⭐⭐⭐</div>
                    <p class="text-muted fst-italic">"Beautiful place with great coffee. Perfect for taking photos while enjoying a delicious cup."</p>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 44px; height: 44px; font-weight: 700;">D</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Dinda Permata</h6>
                            <small class="text-muted">Content Creator</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- CTA SECTION -->
<!-- ============================================ -->
<section class="cta-section py-5">
    <div class="container">
        <div class="bg-dark text-white p-5 rounded-4" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold">Ready for Your <span class="text-warning">Perfect Coffee</span>?</h2>
                    <p class="text-white-50">Join thousands of coffee lovers who start their day with us.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @if(Auth::check())
                        <a href="{{ route('user.menus.index') }}" class="btn btn-warning btn-lg px-5">
                            Order Now →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5">
                            Join Now →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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