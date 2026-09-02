@extends('layouts.guest')

@section('title', 'Lacak Pengaduan')

@section('content')

{{-- ── Page Header ── --}}
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Lacak Pengaduan</h1>
    <p class="mt-2 text-slate-500 text-sm leading-relaxed">
        Masukkan kode pengaduan yang Anda terima saat mengirim laporan untuk melihat status terkini.
    </p>
</div>

{{-- ── Search Form ── --}}
<form method="POST"
      action="{{ route('complaints.show') }}"
      aria-label="Formulir pelacakan pengaduan"
      class="mb-8">
    @csrf
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <label for="tracking_code" class="sr-only">Kode Pengaduan</label>
            <input type="text"
                   id="tracking_code"
                   name="tracking_code"
                   value="{{ old('tracking_code', isset($complaint) ? $complaint->tracking_code : '') }}"
                   required
                   aria-required="true"
                   aria-describedby="tracking_code_help"
                   autocomplete="off"
                   placeholder="Contoh: SILAP-20260902-A3K9F"
                   class="w-full rounded-xl border px-4 py-3 text-sm font-mono text-slate-800 placeholder-slate-400
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors
                          @error('tracking_code') border-red-400 bg-red-50 @else border-slate-300 bg-white @enderror">
            <p id="tracking_code_help" class="mt-1.5 text-xs text-slate-400 pl-1">
                Kode diberikan saat Anda pertama kali mengirim pengaduan.
            </p>
            @error('tracking_code')
                <p class="mt-1 text-xs text-red-600 pl-1" role="alert">{{ $message }}</p>
            @enderror
        </div>
        <div class="shrink-0">
            <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow-sm
                           hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
                </svg>
                Cari
            </button>
        </div>
    </div>
</form>

{{-- ══════════════════════════════════════════ --}}
{{-- ── Results Section ── --}}
{{-- ══════════════════════════════════════════ --}}

@if(isset($complaint) && request()->isMethod('post'))

    @if($complaint === null)
    {{-- ─ Not Found ─ --}}
    <div role="alert" aria-live="assertive"
         class="rounded-2xl bg-amber-50 border border-amber-200 p-6 text-center">
        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-amber-100 flex items-center justify-center" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-amber-500">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 1.999-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-amber-800">Pengaduan tidak ditemukan</p>
        <p class="text-xs text-amber-600 mt-1">Pastikan kode yang Anda masukkan sudah benar, termasuk huruf kapital dan tanda hubung.</p>
    </div>

    @else
    {{-- ─ Found: Complaint Details ─ --}}

    @php
        $statusConfig = [
            'pending'    => ['label' => 'Menunggu', 'bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400'],
            'invalid'    => ['label' => 'Tidak Valid', 'bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
            'processing' => ['label' => 'Diproses', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
            'resolved'   => ['label' => 'Selesai', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
        ];
        $s = $statusConfig[$complaint->status] ?? $statusConfig['pending'];
    @endphp

    {{-- Complaint Header Card --}}
    <article aria-labelledby="complaint-title" class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-6">
        {{-- Header bar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 sm:px-6 py-4 bg-slate-50 border-b border-slate-200">
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Kode Pengaduan</p>
                <p class="font-mono font-bold text-base text-slate-700 tracking-wider">{{ $complaint->tracking_code }}</p>
            </div>
            <span role="status"
                  aria-label="Status: {{ $s['label'] }}"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $s['bg'] }} {{ $s['text'] }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}" aria-hidden="true"></span>
                {{ $s['label'] }}
            </span>
        </div>

        {{-- Complaint details --}}
        <div class="px-5 sm:px-6 py-5 space-y-4">
            <div>
                <h2 id="complaint-title" class="text-lg font-bold text-slate-800">{{ $complaint->title }}</h2>
                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-slate-400">
                    <span>
                        <span aria-hidden="true">📁</span> {{ $complaint->category->name ?? '—' }}
                    </span>
                    <span>
                        <span aria-hidden="true">📅</span>
                        <time datetime="{{ $complaint->created_at->toIso8601String() }}">
                            {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                        </time>
                    </span>
                    @if($complaint->is_disability_friendly)
                    <span class="text-blue-600 font-medium" aria-label="Pengaduan terkait disabilitas">
                        <span aria-hidden="true">♿</span> Terkait Disabilitas
                    </span>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi</h3>
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $complaint->description }}</p>
            </div>

            {{-- Attachments --}}
            @if($complaint->attachments->isNotEmpty())
            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">
                    Lampiran ({{ $complaint->attachments->count() }})
                </h3>
                <ul class="grid grid-cols-2 sm:grid-cols-3 gap-3" aria-label="Lampiran pengaduan">
                    @foreach($complaint->attachments as $attachment)
                    <li>
                        @if($attachment->isImage())
                            <a href="{{ Storage::url($attachment->file_path) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="Buka lampiran gambar {{ $loop->iteration }}">
                                <img src="{{ Storage::url($attachment->file_path) }}"
                                     alt="Lampiran gambar {{ $loop->iteration }}"
                                     loading="lazy"
                                     class="w-full h-24 object-cover rounded-xl border border-slate-200 hover:opacity-90 transition-opacity">
                            </a>
                        @else
                            <a href="{{ Storage::url($attachment->file_path) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="Unduh lampiran video {{ $loop->iteration }}"
                               class="flex flex-col items-center justify-center h-24 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 text-slate-500 hover:border-blue-400 hover:text-blue-600 transition-colors text-xs font-medium gap-1">
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

    {{-- ─ Response Timeline ─ --}}
    <section aria-labelledby="timeline-heading">
        <h2 id="timeline-heading" class="text-base font-semibold text-slate-700 mb-5 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 class="w-5 h-5 text-blue-500" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd"/>
            </svg>
            Riwayat Penanganan
        </h2>

        @if($complaint->responses->isEmpty())
        <div class="text-center py-10 rounded-2xl border-2 border-dashed border-slate-200">
            <p class="text-sm text-slate-400 font-medium">Belum ada respons dari petugas.</p>
            <p class="text-xs text-slate-400 mt-1">Kami akan segera meninjau pengaduan Anda.</p>
        </div>
        @else
        <ol aria-label="Timeline penanganan pengaduan" class="relative">
            {{-- Complaint submitted (always first) --}}
            <li class="relative flex gap-4 pb-8">
                <div class="flex flex-col items-center shrink-0">
                    <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white shadow flex items-center justify-center z-10" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 text-slate-500">
                            <path d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"/>
                            <path d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"/>
                        </svg>
                    </div>
                    <div class="w-px flex-1 bg-slate-200 mt-1" aria-hidden="true"></div>
                </div>
                <div class="flex-1 pb-1">
                    <p class="text-sm font-medium text-slate-700">Pengaduan diterima</p>
                    <time class="text-xs text-slate-400" datetime="{{ $complaint->created_at->toIso8601String() }}">
                        {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                    </time>
                    <p class="text-xs text-slate-500 mt-1">Pengaduan Anda telah masuk ke sistem dan menunggu ditinjau.</p>
                </div>
            </li>

            @foreach($complaint->responses as $response)
            @php
                $isLast = $loop->last;
            @endphp
            <li class="relative flex gap-4 {{ $isLast ? '' : 'pb-8' }}">
                <div class="flex flex-col items-center shrink-0">
                    <div class="w-8 h-8 rounded-full bg-blue-600 border-2 border-white shadow flex items-center justify-center z-10" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="white" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Zm-7-3.5a.5.5 0 0 1 .5.5v2.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 7.793V5a.5.5 0 0 1 .5-.5Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    @if(!$isLast)
                    <div class="w-px flex-1 bg-blue-200 mt-1" aria-hidden="true"></div>
                    @endif
                </div>
                <article class="flex-1 pb-1 bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <p class="text-xs font-semibold text-blue-700">
                            {{ $response->user->name ?? 'Petugas' }}
                        </p>
                        <time class="text-xs text-slate-400 shrink-0"
                              datetime="{{ $response->created_at->toIso8601String() }}">
                            {{ $response->created_at->diffForHumans() }}
                        </time>
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $response->response }}</p>
                </article>
            </li>
            @endforeach
        </ol>
        @endif
    </section>

    @endif {{-- end $complaint check --}}

@elseif(isset($complaint) && $complaint === null)
    {{-- Shown on GET if somehow $complaint is null --}}
    <div class="text-center py-12 text-slate-400 text-sm">Pengaduan tidak ditemukan.</div>
@endif

@endsection

@push('scripts')
<script>
    /* Auto-scroll to results if we have a response */
    @if(isset($complaint) && request()->isMethod('post'))
    document.addEventListener('DOMContentLoaded', function () {
        const results = document.querySelector('article[aria-labelledby="complaint-title"]')
                        ?? document.querySelector('[role="alert"]');
        if (results) {
            results.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
    @endif
</script>
@endpush
