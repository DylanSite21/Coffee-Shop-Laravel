@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
    <style>
        .md-page {
            --md-espresso: #2e1d12;
            --md-roast: #6b4226;
            --md-crema: #c58b55;
            --md-foam: #f7f1e8;
            --md-line: rgba(46, 29, 18, .12);
            max-width: 780px;
        }

        .md-back {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            color: var(--md-roast);
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            margin-bottom: 1rem;
        }

        .md-back:hover {
            color: var(--md-espresso);
        }

        .md-back i {
            transition: transform .2s;
        }

        .md-back:hover i {
            transform: translateX(-3px);
        }

        .md-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 60px -24px rgba(46, 29, 18, .35);
        }

        /* Image side */
        .md-media {
            position: relative;
            min-height: 420px;
            background: var(--md-foam);
            overflow: hidden;
        }

        .md-media img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .8s ease;
        }

        .md-card:hover .md-media img {
            transform: scale(1.05);
        }

        .md-noimg {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            font-size: 5rem;
            color: var(--md-crema);
            background: radial-gradient(circle at 30% 20%, #fff, var(--md-foam));
        }

        .md-category {
            position: absolute;
            top: 1.1rem;
            left: 1.1rem;
            padding: .35rem .9rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(8px);
            color: var(--md-roast);
            font-size: .8rem;
            font-weight: 600;
        }

        /* Content side */
        .md-body {
            display: flex;
            flex-direction: column;
            padding: 2.25rem 2.25rem 2rem;
        }

        .md-name {
            font-size: clamp(1.7rem, 3vw, 2.3rem);
            font-weight: 800;
            line-height: 1.15;
            color: var(--md-espresso);
            margin: 0 0 .5rem;
        }

        .md-price {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--md-crema);
            margin-bottom: 1.25rem;
        }

        .md-price small {
            font-size: .95rem;
            font-weight: 600;
            margin-right: .2rem;
        }

        .md-desc {
            color: #5b4a3f;
            line-height: 1.7;
            max-width: 46ch;
            margin: 0 0 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--md-line);
        }

        .md-stock {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        .md-stock::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        .md-stock.ok {
            color: #2f7d4f;
        }

        .md-stock.low {
            color: #b7791f;
        }

        .md-form {
            margin-top: auto;
        }

        .md-label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            color: var(--md-roast);
            margin-bottom: .4rem;
        }

        .md-row {
            display: flex;
            align-items: center;
            gap: .9rem;
            flex-wrap: wrap;
        }

        .md-stepper {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid var(--md-line);
            border-radius: 14px;
            overflow: hidden;
            background: var(--md-foam);
        }

        .md-stepper button {
            width: 44px;
            height: 48px;
            border: 0;
            background: transparent;
            font-size: 1.25rem;
            color: var(--md-espresso);
            cursor: pointer;
            transition: background .15s;
        }

        .md-stepper button:hover {
            background: rgba(197, 139, 85, .2);
        }

        .md-stepper input {
            width: 52px;
            height: 48px;
            border: 0;
            background: transparent;
            text-align: center;
            font-weight: 700;
            color: var(--md-espresso);
            -moz-appearance: textfield;
        }

        .md-stepper input::-webkit-outer-spin-button,
        .md-stepper input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .md-stepper input:focus {
            outline: none;
        }

        .md-submit {
            flex: 1;
            min-width: 200px;
            height: 50px;
            border: 0;
            border-radius: 14px;
            background: var(--md-espresso);
            color: #fff;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }

        .md-submit:hover {
            background: var(--md-roast);
        }

        .md-submit:active {
            transform: scale(.98);
        }

        .md-submit .md-total {
            opacity: .8;
            font-weight: 500;
        }

        .md-stepper:focus-within,
        .md-submit:focus-visible,
        .md-back:focus-visible {
            outline: 3px solid rgba(197, 139, 85, .55);
            outline-offset: 2px;
        }

        .md-soldout {
            padding: 1rem 1.1rem;
            border-radius: 14px;
            background: #fdf0ee;
            color: #9b2c2c;
            display: flex;
            gap: .75rem;
            align-items: flex-start;
            margin-top: auto;
        }

        .md-soldout i {
            font-size: 1.3rem;
        }

        .md-submit[disabled] {
            background: #b9b0a8;
            cursor: not-allowed;
            width: 100%;
            margin-top: .9rem;
        }

        @media (max-width: 767px) {
            .md-card {
                grid-template-columns: 1fr;
                border-radius: 20px;
            }

            .md-media {
                min-height: 260px;
            }

            .md-body {
                padding: 1.5rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .md-media img,
            .md-back i {
                transition: none;
            }

            .md-card:hover .md-media img {
                transform: none;
            }
        }
    </style>

    <div class="md-page">
        <a href="{{ route('user.menus.index') }}" class="md-back">
            <i class="bi bi-arrow-left"></i>Kembali ke menu
        </a>

        <div class="md-card">
            {{-- Image --}}
            <div class="md-media">
                @php
                    $imgUrl = null;
                    if ($menu->image) {
                        if (file_exists(public_path('storage/' . $menu->image))) {
                            $imgUrl = asset('storage/' . $menu->image);
                        } elseif (file_exists(public_path('images/' . $menu->image))) {
                            $imgUrl = asset('images/' . $menu->image);
                        }
                    }
                @endphp

                @if ($imgUrl)
                    <img src="{{ $imgUrl }}" alt="{{ $menu->name }}">
                @else
                    <div class="md-noimg"><i class="bi bi-cup-hot"></i></div>
                @endif

                @if ($menu->category)
                    <span class="md-category">{{ $menu->category->name }}</span>
                @endif
            </div>

            {{-- Content --}}
            <div class="md-body">
                <h1 class="md-name">{{ $menu->name }}</h1>
                <div class="md-price"><small>Rp</small>{{ number_format($menu->price, 0, ',', '.') }}</div>

                @if ($menu->description)
                    <p class="md-desc">{{ $menu->description }}</p>
                @endif

                @if ($menu->stock <= 0)
                    <div class="md-soldout" role="alert">
                        <i class="bi bi-slash-circle-fill"></i>
                        <div>
                            <strong>Stok habis.</strong><br>
                            Menu ini belum bisa dipesan saat ini.
                        </div>
                    </div>
                    <button type="button" class="md-submit" disabled>
                        <i class="bi bi-slash-circle"></i>Tidak dapat dipesan
                    </button>
                @else
                    @if ($menu->stock <= 5)
                        <div class="md-stock low">Sisa {{ $menu->stock }} porsi</div>
                    @else
                        <div class="md-stock ok">Tersedia</div>
                    @endif

                    <form action="{{ route('user.cart.store') }}" method="POST" class="md-form" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                        <label class="md-label" for="qty">Jumlah</label>
                        <div class="md-row">
                            <div class="md-stepper">
                                <button type="button" data-step="-1" aria-label="Kurangi jumlah">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" id="qty" name="quantity" value="1" min="1"
                                    max="{{ $menu->stock }}" required>
                                <button type="button" data-step="1" aria-label="Tambah jumlah">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>

                            <button type="submit" class="md-submit">
                                <i class="bi bi-cart-plus"></i>
                                Tambah ke keranjang
                                <span class="md-total" id="mdTotal"></span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if ($menu->stock > 0)
        <script>
            (function() {
                const price = {{ (int) $menu->price }};
                const max = {{ (int) $menu->stock }};
                const qty = document.getElementById('qty');
                const total = document.getElementById('mdTotal');
                const fmt = n => 'Rp ' + n.toLocaleString('id-ID');

                function sync() {
                    let v = parseInt(qty.value, 10);
                    if (isNaN(v) || v < 1) v = 1;
                    if (v > max) v = max;
                    qty.value = v;
                    total.textContent = '· ' + fmt(price * v);
                }

                document.querySelectorAll('[data-step]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        qty.value = (parseInt(qty.value, 10) || 1) + parseInt(btn.dataset.step, 10);
                        sync();
                    });
                });

                qty.addEventListener('input', sync);
                sync();
            })();
        </script>
    @endif
@endsection
