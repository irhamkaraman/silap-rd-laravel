@extends('layouts.guest')
@section('title', 'Buat Pengaduan')

@section('seo')
    <x-seo 
        title="Buat Pengaduan - SILAPRADI" 
        description="Buat pengaduan baru di Sistem Informasi Layanan Pengaduan Ramah Disabilitas (SILAPRADI)."
        image="{{ asset('img/example_lapor_view.png') }}"
    />
@endsection

@section('content')

{{-- ── SUCCESS STATE ─────────────────────────────────────────────────────── --}}
@if(isset($trackingCode))
<div x-data="trackingCode('{{ $trackingCode }}')"
     x-intersect.once="$el.classList.add('visible')"
     class="reveal max-w-xl mx-auto text-center py-8">

    {{-- Animated check icon --}}
    <div class="relative w-20 h-20 mx-auto mb-6">
        <div class="absolute inset-0 rounded-full animate-ping opacity-20"
             style="background: rgba(34,197,94,0.4);"></div>
        <div class="relative w-20 h-20 rounded-full flex items-center justify-center shadow-xl"
             style="background: linear-gradient(135deg, #22c55e, #16a34a);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-10 h-10" aria-hidden="true">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>

    <h1 class="text-4xl font-bold mb-2 serif-title" style="color: var(--text-primary)">Pengaduan Berhasil Dikirim!</h1>
    <p class="text-sm mb-8" style="color: var(--text-secondary)">Simpan kode unik berikut untuk memantau status pengaduan Anda.</p>

    {{-- Tracking code card --}}
    <div class="glass-deep rounded-2xl p-6 mb-6 inline-block w-full">
        <p class="text-xs font-semibold uppercase tracking-widest mb-3" style="color: var(--text-muted)">Kode Pengaduan Anda</p>
        <div class="relative">
            <p id="tracking-code-display"
               class="text-3xl font-mono font-bold tracking-widest select-all mb-4"
               style="color: #6366f1; font-family: var(--font-mono);"
               aria-label="Kode pengaduan: {{ $trackingCode }}">
                {{ $trackingCode }}
            </p>
            {{-- Animated underline --}}
            <div class="h-px w-24 mx-auto rounded-full mb-4" style="background: var(--gradient-accent);"></div>
        </div>

        <button @click="copy()"
                class="btn-primary w-full justify-center transition-all"
                :class="copied ? 'opacity-90 scale-95' : ''"
                aria-label="Salin kode pengaduan">
            <template x-if="!copied">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                    <path d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z"/>
                    <path d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z"/>
                </svg>
            </template>
            <template x-if="!copied"><span>Salin Kode</span></template>
            <template x-if="copied">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                </svg>
            </template>
            <template x-if="copied"><span>Tersalin! ✓</span></template>
        </button>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('complaints.track') }}" class="btn-ghost text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
            </svg>
            Lacak Pengaduan
        </a>
        <a href="{{ route('complaints.create') }}" class="btn-ghost text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z"/>
            </svg>
            Buat Pengaduan Baru
        </a>
    </div>
</div>

@else

{{-- ── PAGE HEADER ─────────────────────────────────────────────────────── --}}
<div class="stagger max-w-2xl mb-10">
    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight mb-3 serif-title" style="color: var(--text-primary)">
        Buat Pengaduan
    </h1>
    <p class="text-base leading-relaxed" style="color: var(--text-secondary)">
        Sampaikan pengaduan Anda secara anonim atau dengan identitas.<br class="hidden sm:block">
        Semua laporan akan diproses sesuai prosedur yang berlaku.
    </p>
</div>

{{-- ── VALIDATION ERRORS ─────────────────────────────────────────────────── --}}
@if($errors->any())
<div role="alert" aria-live="assertive"
     x-data="{ show: true }" x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-(-4)"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="mb-6 rounded-2xl p-4 flex gap-3 relative overflow-hidden"
     style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25);">
    <div class="absolute top-0 left-0 w-1 h-full rounded-l-2xl" style="background: #ef4444;"></div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#ef4444" class="w-5 h-5 shrink-0 mt-0.5" aria-hidden="true">
        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
    </svg>
    <div class="flex-1">
        <p class="text-sm font-semibold mb-1" style="color: #dc2626;">Mohon perbaiki kesalahan berikut:</p>
        <ul class="space-y-0.5">
            @foreach($errors->all() as $error)
            <li class="text-xs" style="color: var(--text-secondary);">• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors self-start" aria-label="Tutup pesan error">✕</button>
</div>
@endif

{{-- ── COMPLAINT FORM ────────────────────────────────────────────────────── --}}
<form x-data="complaintForm()"
      method="POST"
      action="{{ route('complaints.store') }}"
      enctype="multipart/form-data"
      @submit.prevent="submit(); $el.submit()"
      novalidate
      aria-label="Formulir pengaduan">
    @csrf

    <div class="space-y-5">

        {{-- ─── SECTION 1: Identitas ──────────────────────────────────────── --}}
        <section
            x-intersect.once="$el.classList.add('visible')"
            class="reveal glass rounded-2xl p-5 sm:p-6"
            aria-labelledby="section-identity">

            <div class="flex items-start justify-between gap-2 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 text-sm font-bold text-white"
                         style="background: var(--gradient-accent);" aria-hidden="true">1</div>
                    <h2 id="section-identity" class="text-lg font-semibold serif-title" style="color: var(--text-primary)">Identitas Pelapor</h2>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="reporter_name" class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted)">
                        Nama Lengkap
                    </label>
                    <input type="text" id="reporter_name" name="reporter_name"
                           value="{{ old('reporter_name') }}"
                           autocomplete="name"
                           placeholder="Nama Anda (opsional)"
                           aria-describedby="reporter_name_help"
                           class="input-glass @error('reporter_name') error @enderror">
                    <p id="reporter_name_help" class="mt-1.5 text-xs" style="color: var(--text-muted)">Biarkan kosong untuk melapor secara anonim.</p>
                    @error('reporter_name')
                        <p class="mt-1 text-xs font-medium" style="color: #ef4444;" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="reporter_contact" class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted)">
                        Nomor HP / Email
                    </label>
                    <input type="text" id="reporter_contact" name="reporter_contact"
                           value="{{ old('reporter_contact') }}"
                           autocomplete="tel"
                           placeholder="08xx / email@contoh.com"
                           aria-describedby="reporter_contact_help"
                           class="input-glass @error('reporter_contact') error @enderror">
                    <p id="reporter_contact_help" class="mt-1.5 text-xs" style="color: var(--text-muted)">Untuk klarifikasi jika diperlukan.</p>
                    @error('reporter_contact')
                        <p class="mt-1 text-xs font-medium" style="color: #ef4444;" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Disability checkbox --}}
            <div class="rounded-xl p-4 transition-all duration-200"
                 style="background: rgba(99,102,241,0.07); border: 1px solid rgba(99,102,241,0.15);"
                 x-data="{ checked: {{ old('is_disability_friendly') ? 'true' : 'false' }}, showTip: false }">
                <div class="flex items-start gap-3">
                    <div class="relative flex-shrink-0 mt-0.5">
                        <input type="checkbox"
                               id="is_disability_friendly"
                               name="is_disability_friendly"
                               value="1"
                               x-model="checked"
                               aria-describedby="disability_help"
                               class="peer sr-only">
                        <div @click="checked = !checked"
                             class="w-5 h-5 rounded-md border-2 cursor-pointer flex items-center justify-center transition-all duration-200"
                             :style="checked
                                ? 'background: linear-gradient(135deg,#6366f1,#3b82f6); border-color: #6366f1;'
                                : 'background: transparent; border-color: rgba(148,163,184,0.5);'">
                            <svg x-show="checked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" fill="white" class="w-3 h-3" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.354 3.146a.5.5 0 0 1 0 .708l-5.5 5.5a.5.5 0 0 1-.708 0l-2.5-2.5a.5.5 0 1 1 .708-.708L4.5 8.293l5.146-5.147a.5.5 0 0 1 .708 0Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <label for="is_disability_friendly" class="text-sm font-semibold cursor-pointer" style="color: #6366f1;">
                                Saya atau yang dilaporkan adalah penyandang disabilitas
                            </label>
                            <button type="button"
                                    @click="showTip = !showTip"
                                    :aria-expanded="showTip"
                                    aria-label="Info tentang layanan ramah disabilitas"
                                    class="w-5 h-5 rounded-full text-[10px] font-bold inline-flex items-center justify-center transition-all"
                                    style="background: rgba(99,102,241,0.2); color: #6366f1;">?</button>
                        </div>
                        <p id="disability_help"
                           x-show="showTip"
                           x-transition
                           class="mt-2 text-xs leading-relaxed p-3 rounded-lg"
                           style="background: rgba(99,102,241,0.1); color: var(--text-secondary);">
                            ♿ Centang ini agar pengaduan Anda mendapat prioritas penanganan dan kami dapat menyesuaikan layanan sesuai kebutuhan aksesibilitas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── SECTION 2: Detail Pengaduan ─────────────────────────────── --}}
        <section
            x-intersect.once="$el.classList.add('visible')"
            class="reveal glass rounded-2xl p-5 sm:p-6"
            style="transition-delay: 0.1s;"
            aria-labelledby="section-detail">

            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 text-sm font-bold text-white"
                     style="background: var(--gradient-accent);" aria-hidden="true">2</div>
                <h2 id="section-detail" class="text-lg font-semibold serif-title" style="color: var(--text-primary)">Detail Pengaduan</h2>
            </div>

            <div class="space-y-4">
                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted)">
                        Kategori <span class="text-red-400" aria-label="wajib">*</span>
                    </label>
                    <select id="category_id" name="category_id" required aria-required="true"
                            class="input-glass @error('category_id') error @enderror">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>— Pilih kategori pengaduan —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs font-medium" style="color: #ef4444;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted)">
                        Judul Pengaduan <span class="text-red-400" aria-label="wajib">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title') }}"
                           required aria-required="true"
                           maxlength="191"
                           placeholder="Ringkasan singkat masalah Anda"
                           class="input-glass @error('title') error @enderror">
                    @error('title')
                        <p class="mt-1 text-xs font-medium" style="color: #ef4444;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted)">
                        Deskripsi Lengkap <span class="text-red-400" aria-label="wajib">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5"
                              required aria-required="true"
                              aria-describedby="description_help"
                              placeholder="Jelaskan kejadian, lokasi, waktu, dan pihak yang terlibat secara detail..."
                              class="input-glass resize-y @error('description') error @enderror">{{ old('description') }}</textarea>
                    <p id="description_help" class="mt-1.5 text-xs" style="color: var(--text-muted)">Minimal 20 karakter. Semakin detail, semakin cepat ditangani.</p>
                    @error('description')
                        <p class="mt-1 text-xs font-medium" style="color: #ef4444;" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- ─── SECTION 3: Lampiran ──────────────────────────────────────── --}}
        <section
            x-data="fileUpload()"
            x-intersect.once="$el.classList.add('visible')"
            class="reveal glass rounded-2xl p-5 sm:p-6"
            style="transition-delay: 0.2s;"
            aria-labelledby="section-attach">

            <div class="flex items-center justify-between gap-2 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 text-sm font-bold text-white"
                         style="background: var(--gradient-accent);" aria-hidden="true">3</div>
                    <h2 id="section-attach" class="text-lg font-semibold serif-title" style="color: var(--text-primary)">Lampiran</h2>
                </div>
                <span class="text-xs italic" style="color: var(--text-muted)">opsional · maks 5 file</span>
            </div>

            {{-- Drop zone --}}
            <label for="attachments"
                   @dragover.prevent="dragging = true"
                   @dragleave.prevent="dragging = false"
                   @drop.prevent="dragging = false; handleFiles($event.dataTransfer.files)"
                   :class="dragging ? 'scale-[1.02] border-indigo-400' : 'border-dashed'"
                   class="relative flex flex-col items-center justify-center w-full min-h-36 rounded-xl cursor-pointer transition-all duration-200 group"
                   style="border: 2px dashed var(--border-subtle);"
                   :style="dragging ? 'border-style: solid; background: rgba(99,102,241,0.08);' : ''">
                <input type="file" id="attachments" name="attachments[]" multiple
                       accept="image/jpeg,image/png,image/gif,video/mp4,video/quicktime,video/x-msvideo,video/webm"
                       aria-describedby="attachments_help"
                       class="absolute inset-0 opacity-0 cursor-pointer"
                       @change="handleFiles($event.target.files)">

                <div class="text-center px-4 py-6 pointer-events-none">
                    <div class="w-12 h-12 rounded-xl mx-auto mb-3 flex items-center justify-center transition-all group-hover:scale-110"
                         style="background: rgba(99,102,241,0.1);" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6" style="color: #6366f1;">
                            <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium" style="color: var(--text-secondary)">Klik atau seret file ke sini</p>
                    <p class="text-xs mt-1" style="color: var(--text-muted)">JPG · PNG · GIF · MP4 · MOV — maks. 20 MB/file</p>
                </div>
            </label>
            <p id="attachments_help" class="sr-only">Unggah hingga 5 file gambar atau video sebagai bukti pengaduan.</p>

            {{-- File preview list --}}
            <template x-if="files.length">
                <ul class="mt-4 space-y-2" aria-label="File yang dipilih" aria-live="polite">
                    <template x-for="(file, i) in files" :key="i">
                        <li class="flex items-center gap-3 p-3 rounded-xl transition-all"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            style="background: var(--bg-glass); border: 1px solid var(--border-subtle);">

                            {{-- Thumbnail --}}
                            <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 flex items-center justify-center"
                                 style="background: rgba(99,102,241,0.1);">
                                <img x-show="file.type === 'image' && file.preview"
                                     :src="file.preview" :alt="file.name"
                                     class="w-full h-full object-cover">
                                <span x-show="file.type === 'video'" class="text-xl" aria-hidden="true">🎥</span>
                                <span x-show="file.type === 'image' && !file.preview" class="text-xl" aria-hidden="true">🖼️</span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium truncate" style="color: var(--text-primary);" x-text="file.name"></p>
                                <p class="text-xs" style="color: var(--text-muted);" x-text="file.size + ' MB'"></p>
                            </div>

                            <button type="button" @click="removeFile(i)"
                                    class="w-6 h-6 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                    style="background: rgba(239,68,68,0.1); color: #ef4444;"
                                    :aria-label="'Hapus file ' + file.name">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5" aria-hidden="true">
                                    <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/>
                                </svg>
                            </button>
                        </li>
                    </template>
                </ul>
            </template>

            @error('attachments')
                <p class="mt-2 text-xs font-medium" style="color: #ef4444;" role="alert">{{ $message }}</p>
            @enderror
        </section>

        {{-- ─── SUBMIT ───────────────────────────────────────────────────── --}}
        <div class="flex items-center justify-between gap-4 pt-2">
            <p class="text-xs" style="color: var(--text-muted)">
                <span class="text-red-400">*</span> Wajib diisi
            </p>
            <button type="submit"
                    class="btn-primary"
                    :disabled="loading"
                    id="submit-btn"
                    aria-describedby="submit-notice">
                <template x-if="!loading">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                        <path d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z"/>
                    </svg>
                </template>
                <template x-if="loading">
                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </template>
                <span x-text="loading ? 'Mengirim…' : 'Kirim Pengaduan'"></span>
            </button>
        </div>
        <p id="submit-notice" class="text-xs text-right mt-2" style="color: var(--text-muted)">
            Dengan mengirim, Anda menyatakan informasi yang disampaikan adalah benar.
        </p>

    </div>
</form>

@endif
@endsection
