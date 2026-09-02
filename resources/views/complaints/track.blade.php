@extends('layouts.guest')
@section('title', 'Lacak Pengaduan')

@section('seo')
    <x-seo 
        title="Lacak Pengaduan - SILAPRADI" 
        description="Lacak status pengaduan Anda di Sistem Informasi Layanan Pengaduan Ramah Disabilitas (SILAPRADI)."
        image="{{ asset('img/example_cek_status.png') }}"
    />
@endsection

@section('content')

{{-- ── PAGE HEADER ─────────────────────────────────────────────────────── --}}
<div class="stagger max-w-xl mb-10">
    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight mb-3 serif-title" style="color: var(--text-primary)">Lacak Pengaduan</h1>
    <p class="text-base leading-relaxed" style="color: var(--text-secondary)">
        Masukkan kode yang Anda terima saat mengirim laporan<br class="hidden sm:block">
        untuk melihat status dan riwayat penanganan.
    </p>
</div>

{{-- ── SEARCH FORM ─────────────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('complaints.show') }}"
      aria-label="Formulir lacak pengaduan" class="mb-10">
    @csrf
    <div class="glass rounded-2xl p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <label for="tracking_code" class="sr-only">Kode Pengaduan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" style="color: var(--text-muted);">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input type="text" id="tracking_code" name="tracking_code"
                           value="{{ old('tracking_code', isset($complaint) ? $complaint->tracking_code : '') }}"
                           required aria-required="true"
                           aria-describedby="tracking_code_help"
                           autocomplete="off" spellcheck="false"
                           placeholder="Contoh: SILAP-20260902-A3K9F"
                           class="input-glass pl-10 @error('tracking_code') error @enderror"
                           style="font-family: var(--font-mono); letter-spacing: 0.05em;">
                </div>
                <p id="tracking_code_help" class="mt-1.5 text-xs pl-1" style="color: var(--text-muted)">
                    Kode diberikan saat Anda pertama kali mengirim pengaduan.
                </p>
                @error('tracking_code')
                    <p class="mt-1 text-xs font-medium pl-1" style="color: #ef4444;" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="shrink-0 sm:self-start">
                <button type="submit" class="btn-primary w-full sm:w-auto whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
                    </svg>
                    Cari Pengaduan
                </button>
            </div>
        </div>
    </div>
</form>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{-- ── RESULTS ─────────────────────────────────────────────────────────── --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}

@if(isset($complaint) && request()->isMethod('post'))

    @if($complaint === null)
    {{-- ── NOT FOUND ─────────────────────────────────────────────────── --}}
    <div role="alert" aria-live="assertive"
         x-data x-intersect.once="$el.classList.add('visible')"
         class="reveal glass rounded-2xl p-8 text-center">
        <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center"
             style="background: rgba(245,158,11,0.12);" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8" style="color: #f59e0b;">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 1.999-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
            </svg>
        </div>
        <p class="text-base font-bold mb-1" style="color: var(--text-primary);">Pengaduan Tidak Ditemukan</p>
        <p class="text-sm" style="color: var(--text-secondary);">Periksa kembali kode Anda — pastikan huruf kapital dan tanda hubung sudah benar.</p>
    </div>

    @else
    {{-- ── FOUND: Complaint Detail ───────────────────────────────────── --}}
    @php
        $statusMap = [
            'pending'    => ['label' => 'Menunggu Verifikasi', 'class' => 'badge-pending',    'dot' => '#f59e0b'],
            'invalid'    => ['label' => 'Tidak Valid',         'class' => 'badge-invalid',    'dot' => '#ef4444'],
            'processing' => ['label' => 'Sedang Diproses',     'class' => 'badge-processing', 'dot' => '#6366f1'],
            'resolved'   => ['label' => 'Selesai',             'class' => 'badge-resolved',   'dot' => '#22c55e'],
        ];
        $s = $statusMap[$complaint->status] ?? $statusMap['pending'];
    @endphp

    <div x-data x-intersect.once="$el.classList.add('visible')" class="reveal space-y-5">

        {{-- ─ Complaint card ─ --}}
        <article aria-labelledby="complaint-title" class="glass rounded-2xl overflow-hidden">

            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3 px-5 sm:px-6 py-4"
                 style="background: var(--bg-glass); border-bottom: 1px solid var(--border-subtle);">
                <div>
                    <p class="text-xs uppercase tracking-widest mb-1 font-semibold" style="color: var(--text-muted);">Kode Pengaduan</p>
                    <p class="font-bold text-lg tracking-wider" style="font-family: var(--font-mono); color: #6366f1;">
                        {{ $complaint->tracking_code }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    @if($complaint->is_disability_friendly)
                    <span class="badge" style="background: rgba(99,102,241,0.12); color: #6366f1; border: 1px solid rgba(99,102,241,0.2);"
                          aria-label="Pengaduan terkait disabilitas">
                        ♿ Disabilitas
                    </span>
                    @endif
                    <span role="status"
                          aria-label="Status: {{ $s['label'] }}"
                          class="badge {{ $s['class'] }}">
                        <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: {{ $s['dot'] }};" aria-hidden="true"></span>
                        {{ $s['label'] }}
                    </span>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-5 sm:px-6 py-5 space-y-5">
                {{-- Title + meta --}}
                <div>
                    <h2 id="complaint-title" class="text-2xl font-bold mb-2 serif-title" style="color: var(--text-primary);">
                        {{ $complaint->title }}
                    </h2>
                    <div class="flex flex-wrap gap-x-5 gap-y-1.5 text-xs" style="color: var(--text-muted);">
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 shrink-0" aria-hidden="true">
                                <path d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z"/>
                            </svg>
                            {{ $complaint->category->name ?? '—' }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 shrink-0" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4 1.75a.75.75 0 0 1 1.5 0V3h5V1.75a.75.75 0 0 1 1.5 0V3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2V1.75ZM4.5 7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7ZM4 9.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1H4Z" clip-rule="evenodd"/>
                            </svg>
                            <time datetime="{{ $complaint->created_at->toIso8601String() }}">
                                {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                            </time>
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest mb-2" style="color: var(--text-muted);">Deskripsi</h3>
                    <p class="text-sm leading-relaxed whitespace-pre-line" style="color: var(--text-secondary);">{{ $complaint->description }}</p>
                </div>

                {{-- Attachments --}}
                @if($complaint->attachments->isNotEmpty())
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest mb-3" style="color: var(--text-muted);">
                        Lampiran ({{ $complaint->attachments->count() }})
                    </h3>
                    <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" aria-label="Lampiran pengaduan">
                        @foreach($complaint->attachments as $attachment)
                        <li>
                            @if($attachment->file_type === 'image')
                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" rel="noopener noreferrer"
                                   aria-label="Buka lampiran gambar {{ $loop->iteration }}"
                                   class="block group overflow-hidden rounded-xl" style="border: 1px solid var(--border-subtle);">
                                    <img src="{{ Storage::url($attachment->file_path) }}"
                                         alt="Lampiran {{ $loop->iteration }}" loading="lazy"
                                         class="w-full h-28 object-cover transition-transform duration-300 group-hover:scale-105">
                                </a>
                            @else
                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" rel="noopener noreferrer"
                                   aria-label="Buka video {{ $loop->iteration }}"
                                   class="flex flex-col items-center justify-center h-28 rounded-xl text-xs font-medium gap-2 transition-all"
                                   style="background: rgba(99,102,241,0.08); border: 1px dashed rgba(99,102,241,0.25); color: #6366f1;">
                                    <span class="text-2xl" aria-hidden="true">🎥</span>
                                    Video {{ $loop->iteration }}
                                </a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </article>

        {{-- ─ Response Timeline ─────────────────────────────────────────── --}}
        <section aria-labelledby="timeline-heading">
            <h2 id="timeline-heading" class="flex items-center gap-2.5 text-xl font-bold mb-5 serif-title" style="color: var(--text-primary);">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: rgba(99,102,241,0.12);" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4" style="color: #6366f1;">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8Zm7.75-4.25a.75.75 0 0 0-1.5 0V8c0 .414.336.75.75.75h3.25a.75.75 0 0 0 0-1.5h-2.5v-3.5Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                Riwayat Penanganan
            </h2>

            @if($complaint->responses->isEmpty())
            <div class="glass rounded-2xl p-10 text-center">
                <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center"
                     style="background: rgba(99,102,241,0.08);" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7" style="color: var(--text-muted);">
                        <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold mb-1" style="color: var(--text-primary);">Belum ada respons</p>
                <p class="text-xs" style="color: var(--text-muted);">Petugas kami akan segera meninjau dan merespons pengaduan Anda.</p>
            </div>

            @else
            <ol aria-label="Timeline penanganan" class="relative space-y-0 pl-12">
                {{-- Vertical line --}}
                <div class="absolute left-4 top-8 bottom-4 w-px"
                     style="background: linear-gradient(to bottom, rgba(99,102,241,0.5), rgba(99,102,241,0.05));"
                     aria-hidden="true"></div>

                {{-- First entry: complaint submitted --}}
                <li class="relative pb-6">
                    <div class="absolute -left-12 top-0.5 w-8 h-8 rounded-full flex items-center justify-center shadow-sm z-10"
                         style="background: var(--bg-surface); border: 2px solid var(--border-subtle);" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4" style="color: var(--text-muted);">
                            <path d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"/>
                            <path d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">Pengaduan diterima sistem</p>
                        <time class="text-xs" style="color: var(--text-muted);" datetime="{{ $complaint->created_at->toIso8601String() }}">
                            {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                        </time>
                        <p class="text-xs mt-1" style="color: var(--text-secondary);">Pengaduan Anda telah masuk dan menunggu tinjauan petugas.</p>
                    </div>
                </li>

                {{-- Responses --}}
                @foreach($complaint->responses as $response)
                @php $isLast = $loop->last; @endphp
                <li class="relative {{ $isLast ? '' : 'pb-6' }}"
                    x-data x-intersect.once="$el.classList.add('visible')"
                    class="reveal"
                    style="transition-delay: {{ $loop->index * 0.1 }}s;">
                    <div class="absolute -left-12 top-0.5 w-8 h-8 rounded-full flex items-center justify-center shadow-md z-10"
                         style="background: var(--gradient-accent);" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="white" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.062l4.25-5.5Z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <article class="glass-deep rounded-xl p-4 ml-2">
                        <div class="flex items-center justify-between gap-3 mb-2 flex-wrap">
                            @php
                                $responderName = 'Sistem';
                                if ($response->user) {
                                    $responderName = $response->user->name;
                                    $agencyName = $response->user->agency?->name ?? $complaint->agency?->name;
                                    if ($agencyName) {
                                        $responderName .= ' (' . $agencyName . ')';
                                    }
                                }
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                  style="background: rgba(99,102,241,0.12); color: #6366f1;">
                                {{ $responderName }}
                            </span>
                            <time class="text-xs" style="color: var(--text-muted);"
                                  datetime="{{ $response->created_at->toIso8601String() }}"
                                  :title="'{{ $response->created_at->format('d M Y, H:i') }}'">
                                {{ $response->created_at->diffForHumans() }}
                            </time>
                        </div>
                        <p class="text-sm leading-relaxed whitespace-pre-line" style="color: var(--text-secondary);">{{ $response->response }}</p>
                    </article>
                </li>
                @endforeach
            </ol>
            @endif
        </section>

    </div>{{-- .reveal --}}

    @endif

@endif
@endsection

@push('scripts')
<script>
    @if(isset($complaint) && $complaint && request()->isMethod('post'))
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.querySelector('article[aria-labelledby="complaint-title"]');
        if (el) { setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 200); }
    });
    @endif
</script>
@endpush
