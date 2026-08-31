<div class="col-md-4 col-lg-3 mb-4">
    <div class="card menu-card h-100 border-0 shadow-sm">

        {{-- Gambar Menu --}}
        <div class="menu-card-image position-relative">
            @if ($menu->image)
                @if (file_exists(public_path('storage/' . $menu->image)))
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="card-img-top">
                @elseif (file_exists(public_path('images/' . $menu->image)))
                    <img src="{{ asset('images/' . $menu->image) }}" alt="{{ $menu->name }}" class="card-img-top">
                @endif
            @else
                <div class="no-image">
                    <i class="bi bi-cup-hot"></i>
                </div>
            @endif

            @if($menu->stock <= 0)
                <span class="badge bg-danger text-white position-absolute top-0 end-0 m-2 px-2 py-1 shadow-sm" style="font-size: 0.75rem;">
                    <i class="bi bi-slash-circle me-1"></i>Stok Habis
                </span>
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

                @if($menu->stock <= 0)
                    <a href="{{ route('user.menus.show', $menu) }}" class="btn btn-outline-danger w-100">
                        <i class="bi bi-x-circle me-1"></i>Stok Habis
                    </a>
                @else
                    <a href="{{ route('user.menus.show', $menu) }}" class="btn btn-coffee w-100">
                        Lihat Detail
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>
