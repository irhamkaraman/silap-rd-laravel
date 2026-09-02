<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Layanan Pengaduan Ramah Disabilitas – SILAP-RD. Sampaikan pengaduan Anda dengan mudah dan aman.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SILAP-RD') — Layanan Pengaduan Ramah Disabilitas</title>

    {{-- Tailwind CSS v4 (via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert2 via CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* ─── SweetAlert2 Minimalist Overrides ─── */
        .swal2-popup {
            padding: 1.25rem 1.5rem 1.5rem !important;
            border-radius: 1rem !important;
            box-shadow: 0 4px 24px 0 rgb(0 0 0 / 0.10) !important;
            font-size: 0.9rem !important;
            max-width: 360px !important;
            width: auto !important;
        }
        .swal2-title {
            font-size: 1rem !important;
            font-weight: 600 !important;
            padding: 0 !important;
            margin-bottom: 0.25rem !important;
            color: #1e293b !important;
        }
        .swal2-html-container {
            font-size: 0.85rem !important;
            color: #475569 !important;
            margin: 0.5rem 0 0 0 !important;
            padding: 0 !important;
        }
        .swal2-icon {
            width: 3rem !important;
            height: 3rem !important;
            margin: 0 auto 0.75rem !important;
            border-width: 2px !important;
        }
        .swal2-icon .swal2-icon-content {
            font-size: 1.5rem !important;
        }
        .swal2-actions {
            margin-top: 1rem !important;
            gap: 0.5rem !important;
        }
        .swal2-confirm, .swal2-cancel {
            font-size: 0.8rem !important;
            padding: 0.4rem 1.2rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            box-shadow: none !important;
        }
        .swal2-confirm {
            background-color: #2563eb !important;
        }
        .swal2-confirm:focus {
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.3) !important;
        }
        .swal2-close {
            font-size: 1.2rem !important;
        }
        /* ─── Toast variant ─── */
        .swal2-toast .swal2-popup {
            max-width: 320px !important;
            padding: 0.75rem 1rem !important;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 font-sans antialiased">

    {{-- Skip-to-content link for screen readers --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-blue-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg focus:text-sm focus:font-medium">
        Langsung ke konten
    </a>

    {{-- ── Navigation Bar ── --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <a href="{{ route('complaints.create') }}"
               class="flex items-center gap-2.5 group"
               aria-label="SILAP-RD — Halaman Utama">
                {{-- Logo / Badge --}}
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-700 transition-colors"
                     aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4.5 h-4.5">
                        <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
                        <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-sm font-semibold text-slate-800 leading-none">SILAP-RD</span>
                    <span class="block text-[10px] text-slate-500 leading-none mt-0.5 hidden sm:block">Layanan Pengaduan Ramah Disabilitas</span>
                </div>
            </a>

            <nav aria-label="Menu utama">
                <ul class="flex items-center gap-1">
                    <li>
                        <a href="{{ route('complaints.create') }}"
                           class="text-sm px-3 py-1.5 rounded-lg font-medium transition-colors
                                  {{ request()->routeIs('complaints.create') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                            Buat Pengaduan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('complaints.track') }}"
                           class="text-sm px-3 py-1.5 rounded-lg font-medium transition-colors
                                  {{ request()->routeIs('complaints.track') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                            Lacak Pengaduan
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    {{-- ── Main Content ── --}}
    <main id="main-content" class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    <footer class="border-t border-slate-200 mt-16 py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center text-xs text-slate-400">
            <p>© {{ date('Y') }} SILAP-RD — Sistem Informasi Layanan Pengaduan Ramah Disabilitas.</p>
            <p class="mt-1">Dibangun untuk masyarakat yang inklusif dan berkeadilan.</p>
        </div>
    </footer>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Flash messages → SweetAlert2 --}}
    @if(session('swal_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html: `{{ session('swal_success') }}`,
        });
    </script>
    @endif
    @if(session('swal_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: `{{ session('swal_error') }}`,
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
