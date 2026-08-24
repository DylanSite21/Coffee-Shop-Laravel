<div class="col-md-4 col-lg-3 mb-4">
    <div class="card menu-card h-100 border-0 shadow-sm">

        {{-- Gambar Menu --}}
        <div class="menu-card-image">
            @if ($menu->image)
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="card-img-top">
            @else
                <div class="no-image">
                    <i class="bi bi-cup-hot"></i>
                </div>
            @endif
        </div>

        <div class="card-body d-flex flex-column">

            {{-- Kategori --}}
            <span class="menu-category">
                {{ $menu->category->name ?? '-' }}
            </span>

            {{-- Nama --}}
            <h5 class="menu-title">
                {{ $menu->name }}
            </h5>

            {{-- Deskripsi --}}
            <p class="menu-description">
                {{ $menu->description }}
            </p>

            {{-- Harga + Button --}}
            <div class="mt-auto">
                <div class="menu-price mb-3">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </div>

                <a href="{{ route('user.menus.show', $menu) }}" class="btn btn-coffee w-100">
                    Lihat Detail
                </a>
            </div>

        </div>
    </div>
</div>
