<footer class="footer mt-auto">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row g-4">
            {{-- Brand Column --}}
            <div class="col-lg-4">
                <div class="footer-brand">☕ Kopi Nusantara</div>
                <p class="footer-tagline">Dari biji pilihan, untuk secangkir cerita</p>
                <p style="font-size:0.875rem;color:#C8A882;line-height:1.7;max-width:300px;">
                    Kopi Nusantara hadir menghadirkan pengalaman menikmati kopi premium Indonesia yang autentik,
                    disiapkan dengan penuh dedikasi oleh barista berpengalaman kami.
                </p>
                <div class="footer-social mt-3">
                    <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" title="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            {{-- Menu Column --}}
            <div class="col-lg-2 col-md-4">
                <h6>Menu Cepat</h6>
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/#menu-section') }}">Menu Kami</a>
                <a href="{{ url('/#tentang') }}">Tentang Kami</a>
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'manager' ? route('manager.dashboard') : route('user.dashboard')) }}">Dashboard</a>
                @endguest
            </div>

            {{-- Info Column --}}
            <div class="col-lg-3 col-md-4">
                <h6>Jam Operasional</h6>
                <div style="font-size:0.875rem;color:#C8A882;line-height:2;">
                    <div class="d-flex justify-content-between">
                        <span>Senin – Jumat</span>
                        <span style="color:#FDF6ED;font-weight:600;">07.00 – 22.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Sabtu</span>
                        <span style="color:#FDF6ED;font-weight:600;">08.00 – 23.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Minggu</span>
                        <span style="color:#FDF6ED;font-weight:600;">09.00 – 21.00</span>
                    </div>
                </div>
                <div class="mt-3" style="font-size:0.875rem;color:#C8A882;">
                    <div><i class="bi bi-geo-alt me-2" style="color:#D4A855;"></i>Jl. Kopi Indah No. 17, Jakarta</div>
                </div>
            </div>

            {{-- Contact Column --}}
            <div class="col-lg-3 col-md-4">
                <h6>Hubungi Kami</h6>
                <div style="font-size:0.875rem;color:#C8A882;line-height:2.2;">
                    <div><i class="bi bi-telephone me-2" style="color:#D4A855;"></i>+62 812-3456-7890</div>
                    <div><i class="bi bi-envelope me-2" style="color:#D4A855;"></i>hello@kopinusantara.id</div>
                    <div><i class="bi bi-whatsapp me-2" style="color:#D4A855;"></i>+62 812-3456-7890</div>
                </div>
                <div class="mt-3 p-3" style="background:rgba(255,255,255,0.05);border-radius:0.5rem;border:1px solid rgba(255,255,255,0.08);">
                    <div style="font-size:0.75rem;color:#D4A855;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:0.25rem;">Rating Pelanggan</div>
                    <div style="color:#FDF6ED;font-size:1.1rem;font-weight:700;">⭐ 4.9 / 5.0</div>
                    <div style="font-size:0.75rem;color:#C8A882;">dari 1.200+ ulasan</div>
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="d-flex flex-wrap justify-content-between align-items-center footer-bottom">
            <span>&copy; {{ date('Y') }} Kopi Nusantara. Seluruh hak cipta dilindungi.</span>
            <span>Dibuat dengan ❤️ untuk para pecinta kopi Indonesia</span>
        </div>
    </div>
</footer>
