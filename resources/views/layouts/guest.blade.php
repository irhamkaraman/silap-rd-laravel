<!DOCTYPE html>
<html lang="id" x-data x-init="$store.theme.init()" :class="{ dark: $store.theme.dark }" class="scroll-smooth">
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
    </style>

    @stack('styles')
</head>
<body class="min-h-screen transition-colors duration-300">

    {{-- Skip to content --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-1/2 focus:-translate-x-1/2 focus:z-[9999] focus:px-5 focus:py-2.5 focus:rounded-xl focus:text-sm focus:font-semibold focus:shadow-lg"
       style="background: var(--gradient-accent); color: #fff;">
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
                <a href="{{ route('complaints.create') }}"
                   class="flex items-center gap-3 group"
                   aria-label="SILAP-RD — Beranda">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-md transition-transform duration-300 group-hover:scale-110 animate-float"
                         style="background: var(--gradient-accent);" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-5 h-5">
                            <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
                            <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-sm font-bold" style="color: var(--text-primary)">SILAP-RD</div>
                        <div class="text-[10px] hidden sm:block" style="color: var(--text-muted)">Layanan Pengaduan Ramah Disabilitas</div>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden sm:flex items-center gap-1" aria-label="Menu utama">
                    <a href="{{ route('complaints.create') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('complaints.create') ? 'text-white shadow-md' : 'hover:bg-white/10' }}"
                       style="{{ request()->routeIs('complaints.create') ? 'background: var(--gradient-accent);' : 'color: var(--text-secondary);' }}">
                        Buat Pengaduan
                    </a>
                    <a href="{{ route('complaints.track') }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('complaints.track') ? 'text-white shadow-md' : 'hover:bg-white/10' }}"
                       style="{{ request()->routeIs('complaints.track') ? 'background: var(--gradient-accent);' : 'color: var(--text-secondary);' }}">
                        Lacak Pengaduan
                    </a>

                    {{-- Dark mode toggle --}}
                    <button @click="$store.theme.toggle()"
                            :aria-label="$store.theme.dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap'"
                            class="ml-1 w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200 hover:scale-110"
                            style="background: var(--bg-glass); border: 1px solid var(--border-subtle);">
                        <svg x-show="!$store.theme.dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="w-4 h-4" style="color: var(--text-secondary);" aria-hidden="true">
                            <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2ZM10 15a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15ZM10 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6ZM15.657 5.404a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM6.464 14.596a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10ZM14.596 15.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06L5.404 4.343a.75.75 0 1 0-1.06 1.06l1.06 1.061Z"/>
                        </svg>
                        <svg x-show="$store.theme.dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="w-4 h-4" style="color: #a5b4fc;" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 0 1 .26.77 7 7 0 0 0 9.958 7.967.75.75 0 0 1 1.067.853A8.5 8.5 0 1 1 6.647 1.921a.75.75 0 0 1 .808.083Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
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

            {{-- Mobile Menu --}}
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="sm:hidden pb-4 space-y-1" @click.away="open = false">
                <a href="{{ route('complaints.create') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium transition-all"
                   style="{{ request()->routeIs('complaints.create') ? 'background: var(--gradient-accent); color: white;' : 'color: var(--text-secondary);' }}">
                    Buat Pengaduan
                </a>
                <a href="{{ route('complaints.track') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-medium transition-all"
                   style="{{ request()->routeIs('complaints.track') ? 'background: var(--gradient-accent); color: white;' : 'color: var(--text-secondary);' }}">
                    Lacak Pengaduan
                </a>
                <button @click="$store.theme.toggle()" class="flex items-center gap-2 px-4 py-3 text-sm font-medium rounded-xl w-full" style="color: var(--text-secondary);">
                    <span x-text="$store.theme.dark ? '☀️ Mode Terang' : '🌙 Mode Gelap'"></span>
                </button>
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
