<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ url('/') }}">
            <span class="brand-icon">☕</span>
            Kopi Nusantara
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarNav">
            {{-- <ul class="navbar-nav me-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#menu-section') }}">
                            <i class="bi bi-cup-hot me-1"></i>Menu
                        </a>
                    </li>
                @endguest

                @auth
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'manager')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                                href="{{ route('manager.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                                href="{{ route('user.dashboard') }}">
                                <i class="bi bi-house-door me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.menus.*') ? 'active' : '' }}"
                                href="{{ route('user.menus.index') }}">
                                <i class="bi bi-cup-hot me-1"></i>Menu
                            </a>
                        </li>
                    @endif
                @endauth
            </ul> --}}

            <ul class="navbar-nav align-items-center gap-1 ms-auto">


                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item ms-1">
                        <a class="btn btn-gold btn-sm px-3" href="{{ route('register') }}">Daftar</a>
                    </li>
                @else
                    <li class="nav-item dropdown me-1">
                        @php
                            $unreadCount = 0;
                            $notifications = collect();

                            if (auth()->user()->role === 'user') {
                                $userOrders = \App\Models\Order::where('user_id', auth()->id())
                                    ->latest()
                                    ->take(5)
                                    ->get();
                                $unreadCount = \App\Models\Order::where('user_id', auth()->id())
                                    ->whereIn('status', ['pending', 'processing'])
                                    ->count();
                                foreach ($userOrders as $ord) {
                                    $statusLabel =
                                        [
                                            'pending' => 'Menunggu Pembayaran / Konfirmasi',
                                            'processing' => 'Pesanan Diproses',
                                            'completed' => 'Pesanan Selesai',
                                            'cancelled' => 'Pesanan Dibatalkan',
                                        ][$ord->status] ?? ucfirst($ord->status);

                                    $statusBadge =
                                        [
                                            'pending' => 'bg-warning text-dark',
                                            'processing' => 'bg-info text-dark',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                        ][$ord->status] ?? 'bg-secondary text-white';

                                    $notifications->push([
                                        'title' => "Pesanan #{$ord->order_number}",
                                        'desc' => $statusLabel,
                                        'badge' => $statusBadge,
                                        'status' => $ord->status,
                                        'time' => $ord->updated_at->diffForHumans(),
                                        'link' => route('user.orders.show', $ord->id),
                                    ]);
                                }
                            } elseif (auth()->user()->role === 'manager') {
                                $pendingOrders = \App\Models\Order::where('status', 'pending')
                                    ->latest()
                                    ->take(5)
                                    ->get();
                                $unreadCount = \App\Models\Order::where('status', 'pending')->count();
                                foreach ($pendingOrders as $ord) {
                                    $notifications->push([
                                        'title' => "Pesanan Masuk #{$ord->order_number}",
                                        'desc' => 'Total: Rp ' . number_format($ord->total, 0, ',', '.'),
                                        'badge' => 'bg-warning text-dark',
                                        'status' => 'Pending',
                                        'time' => $ord->created_at->diffForHumans(),
                                        'link' => route('manager.orders.show', $ord->id),
                                    ]);
                                }
                            } elseif (auth()->user()->role === 'admin') {
                                $pendingMenus = \App\Models\Menu::where('status', 'pending')->latest()->take(5)->get();
                                $unreadCount = \App\Models\Menu::where('status', 'pending')->count();
                                foreach ($pendingMenus as $menu) {
                                    $notifications->push([
                                        'title' => "Persetujuan Menu: {$menu->name}",
                                        'desc' => 'Harga: Rp ' . number_format($menu->price, 0, ',', '.'),
                                        'badge' => 'bg-warning text-dark',
                                        'status' => 'Pending',
                                        'time' => $menu->created_at->diffForHumans(),
                                        'link' => route('admin.approvals.index'),
                                    ]);
                                }
                            }
                        @endphp

                        <a class="nav-link position-relative px-2 dropdown-toggle hide-arrow" href="#"
                            id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            title="Notifikasi">
                            <i class="bi bi-bell fs-5"></i>
                            @if ($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown shadow-lg border-0 py-0"
                            aria-labelledby="notificationDropdown"
                            style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center py-2 px-3 border-bottom"
                                style="background-color: var(--color-surface-alt, #2C1A11); color: var(--color-gold, #D4A855);">
                                <span class="fw-bold fs-6 mb-0">Notifikasi</span>
                                @if ($unreadCount > 0)
                                    <span class="badge bg-warning text-dark rounded-pill">{{ $unreadCount }} Baru</span>
                                @endif
                            </li>

                            @if ($notifications->isEmpty())
                                <li class="text-center py-4 text-muted">
                                    <i class="bi bi-bell-slash fs-4 d-block mb-1"></i>
                                    <small>Tidak ada notifikasi baru</small>
                                </li>
                            @else
                                @foreach ($notifications as $notif)
                                    <li>
                                        <a class="dropdown-item py-2 px-3 border-bottom text-wrap d-flex flex-column gap-1"
                                            href="{{ $notif['link'] }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong style="font-size: 0.85rem;"
                                                    class="text-truncate me-2">{{ $notif['title'] }}</strong>
                                                <small class="text-muted ms-auto"
                                                    style="font-size: 0.7rem; white-space: nowrap;">{{ $notif['time'] }}</small>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small"
                                                    style="font-size: 0.78rem;">{{ $notif['desc'] }}</span>
                                                <span class="badge {{ $notif['badge'] }}"
                                                    style="font-size: 0.65rem;">{{ ucfirst($notif['status']) }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                                @if (auth()->user()->role === 'user')
                                    <li class="text-center py-2 bg-light">
                                        <a href="{{ route('user.orders.index') }}"
                                            class="text-decoration-none small fw-semibold text-coffee">Lihat Semua
                                            Pesanan</a>
                                    </li>
                                @elseif(auth()->user()->role === 'manager')
                                    <li class="text-center py-2 bg-light">
                                        <a href="{{ route('manager.orders.index') }}"
                                            class="text-decoration-none small fw-semibold text-coffee">Lihat Semua
                                            Pesanan</a>
                                    </li>
                                @elseif(auth()->user()->role === 'admin')
                                    <li class="text-center py-2 bg-light">
                                        <a href="{{ route('admin.approvals.index') }}"
                                            class="text-decoration-none small fw-semibold text-coffee">Kelola
                                            Persetujuan</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div
                                style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#C08B5C,#D4A855);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:#3E1F0D;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="px-3 py-2 border-bottom" style="border-color:#DEC9AA!important;">
                                    <div style="font-weight:600;font-size:0.875rem;color:#3E1F0D;">
                                        {{ auth()->user()->name }}</div>
                                    <div style="font-size:0.75rem;color:#6B4C3B;">{{ ucfirst(auth()->user()->role) }}
                                    </div>
                                </div>
                            </li>
                            @if (auth()->user()->role === 'user')
                                <li><a class="dropdown-item" href="{{ route('user.orders.index') }}"><i
                                            class="bi bi-receipt me-2"></i>Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                            class="bi bi-person me-2"></i>Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider" style="border-color:#DEC9AA;">
                                </li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
