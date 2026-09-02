<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Layanan Pengaduan Ramah Disabilitas – SILAP-RD. Sampaikan pengaduan Anda dengan mudah dan aman.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SILAP-RD') — Layanan Pengaduan Ramah Disabilitas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* ── SweetAlert2 Minimalist Overrides ── */
        .swal2-popup {
            padding: 1.5rem !important;
            border-radius: 1.25rem !important;
            max-width: 380px !important;
            width: calc(100vw - 2rem) !important;
            font-size: 0.875rem !important;
            background: var(--bg-glass-deep) !important;
            backdrop-filter: blur(24px) !important;
            border: 1px solid var(--border-glass) !important;
            box-shadow: 0 24px 64px rgba(0,0,0,0.20) !important;
            color: var(--text-primary) !important;
        }
        .dark .swal2-popup {
            background: rgba(15, 23, 42, 0.92) !important;
        }
        .swal2-title {
            font-size: 1rem !important;
            font-weight: 700 !important;
            padding: 0 0 0.25rem !important;
            color: var(--text-primary) !important;
        }
        .swal2-html-container {
            font-size: 0.8125rem !important;
            color: var(--text-secondary) !important;
            margin: 0.5rem 0 0 !important;
            padding: 0 !important;
        }
        .swal2-icon { width: 3rem !important; height: 3rem !important; margin: 0 auto 1rem !important; border-width: 2px !important; }
        .swal2-icon .swal2-icon-content { font-size: 1.5rem !important; }
        .swal2-actions { margin-top: 1.25rem !important; gap: 0.5rem !important; }
        .swal2-confirm {
            font-size: 0.8rem !important;
            padding: 0.5rem 1.5rem !important;
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
            background: linear-gradient(135deg, #3b82f6, #6366f1) !important;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35) !important;
        }
        .swal2-cancel {
            font-size: 0.8rem !important;
            padding: 0.5rem 1.5rem !important;
            border-radius: 0.75rem !important;
            font-weight: 500 !important;
            background: transparent !important;
            border: 1px solid var(--border-subtle) !important;
            color: var(--text-secondary) !important;
        }
        .swal2-close { font-size: 1.25rem !important; color: var(--text-muted) !important; }
        .swal2-timer-progress-bar { background: linear-gradient(90deg, #3b82f6, #6366f1) !important; height: 3px !important; }
    <style>
        /* ── Grain & Video Background ── */
        .grain {
            position: fixed;
            inset: -50%;
            width: 200%;
            height: 200%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }
        .hero-photo {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            opacity: 1;
        }
        .hero-photo video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .hero-photo::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(0,0,0,0.85) 0%,
                rgba(0,0,0,0.75) 40%,
                rgba(0,0,0,0.95) 100%
            );
        }
        .serif-title {
            font-family: var(--font-serif);
            font-style: italic;
            font-weight: 400;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen">

    <!-- Grain -->
    <div class="grain" aria-hidden="true"></div>

    <!-- Video background -->
    <div class="hero-photo" aria-hidden="true">
        <video
            src="https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260818_072341_50851634-bbc3-4c33-9acc-7647d4db44aa.mp4"
            autoplay
            muted
            loop
            playsinline
        ></video>
    </div>

    {{-- Skip to content --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-1/2 focus:-translate-x-1/2 focus:z-[9999] focus:px-5 focus:py-2.5 focus:rounded-xl focus:text-sm focus:font-semibold focus:shadow-lg"
       style="background: #ffffff; color: #000;">
        Langsung ke konten
    </a>

    {{-- ══ Navigation Bar ════════════════════════════════════════════════════ --}}
    <header
        x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
        :class="scrolled ? 'glass shadow-lg' : 'bg-transparent'"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">

                {{-- Brand --}}
                <a href="{{ url('/') }}"
                   class="flex items-center gap-3 group"
                   aria-label="SILAP-RD — Beranda">
                    <div class="text-white">
                        <svg class="w-6 h-6 transition-transform group-hover:-rotate-12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <g transform="rotate(-30 12 12)">
                                <circle cx="7.3" cy="3.2" r="1.45"/>
                                <rect x="5.5" y="4.7" width="3.6" height="14.6" rx="1.8"/>
                                <rect x="14.9" y="4.7" width="3.6" height="14.6" rx="1.8"/>
                                <circle cx="16.7" cy="20.8" r="1.45"/>
                            </g>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-sm font-bold text-white tracking-tight">SILAP-RD</div>
                    </div>
                </a>

                <nav class="hidden sm:flex items-center gap-1" aria-label="Menu utama">
                    <a href="{{ route('complaints.create') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300
                              {{ request()->routeIs('complaints.create') ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        Buat Pengaduan
                    </a>
                    <a href="{{ route('complaints.track') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300
                              {{ request()->routeIs('complaints.track') ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        Lacak Pengaduan
                    </a>
                </nav>

                {{-- Mobile hamburger --}}
                <button @click="open = !open"
                        class="sm:hidden w-9 h-9 rounded-xl flex items-center justify-center transition-all"
                        style="background: var(--bg-glass); border: 1px solid var(--border-subtle);"
                        :aria-expanded="open" aria-label="Toggle menu">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="sm:hidden pb-4 space-y-1" @click.away="open = false">
                <a href="{{ route('complaints.create') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('complaints.create') ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white' }}">
                    Buat Pengaduan
                </a>
                <a href="{{ route('complaints.track') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('complaints.track') ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white' }}">
                    Lacak Pengaduan
                </a>
            </div>
        </div>
    </header>

    {{-- ══ Main Content ════════════════════════════════════════════════════ --}}
    <main id="main-content" class="max-w-5xl mx-auto px-4 sm:px-6 pt-24 pb-16 relative z-10">
        @yield('content')
    </main>

    {{-- ══ Footer ══════════════════════════════════════════════════════════ --}}
    <footer class="relative z-10 border-t py-8 mt-8" style="border-color: var(--border-subtle);">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs" style="color: var(--text-muted)">
                © {{ date('Y') }} SILAP-RD — Sistem Informasi Layanan Pengaduan Ramah Disabilitas
            </p>
            <p class="text-xs" style="color: var(--text-muted)">
                Dibangun untuk masyarakat yang inklusif dan berkeadilan 💙
            </p>
        </div>
    </footer>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('swal_success'))
    <script>
        document.addEventListener('alpine:init', () => {
            setTimeout(() => Swal.fire({ icon:'success', title:'Berhasil', html:`{{ session('swal_success') }}` }), 100);
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
