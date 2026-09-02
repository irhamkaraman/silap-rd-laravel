@extends('layouts.guest')

@section('title', 'Buat Pengaduan')

@section('content')

{{-- ── Success State: show tracking code ── --}}
@if(isset($trackingCode))
<div role="alert"
     aria-live="assertive"
     class="mb-8 rounded-2xl bg-green-50 border border-green-200 p-6 sm:p-8 text-center">
    <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-green-600">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
        </svg>
    </div>
    <h1 class="text-xl font-bold text-green-800 mb-1">Pengaduan Berhasil Dikirim!</h1>
    <p class="text-sm text-green-700 mb-5">Simpan kode ini untuk memantau status pengaduan Anda.</p>

    <div class="inline-block bg-white border-2 border-green-400 rounded-xl px-6 py-3 mb-5">
        <p class="text-xs text-slate-500 mb-1 font-medium uppercase tracking-wider">Kode Pengaduan Anda</p>
        <p id="tracking-code-display"
           class="text-2xl font-mono font-bold text-green-700 tracking-widest select-all"
           aria-label="Kode pengaduan: {{ $trackingCode }}">
            {{ $trackingCode }}
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button type="button"
                onclick="copyTrackingCode()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors"
                aria-label="Salin kode pengaduan {{ $trackingCode }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                <path d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z"/>
                <path d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z"/>
            </svg>
            Salin Kode
        </button>
        <a href="{{ route('complaints.track') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-green-400 text-green-700 text-sm font-medium hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
            Lacak Pengaduan
        </a>
        <a href="{{ route('complaints.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-slate-300 text-slate-600 text-sm font-medium hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 transition-colors">
            Buat Pengaduan Baru
        </a>
    </div>
</div>
@else

{{-- ── Page Header ── --}}
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Buat Pengaduan</h1>
    <p class="mt-2 text-slate-500 text-sm leading-relaxed">
        Sampaikan pengaduan Anda secara anonim atau dengan identitas. Semua pengaduan akan diproses sesuai prosedur yang berlaku.
    </p>
</div>

{{-- ── Validation Errors ── --}}
@if($errors->any())
<div role="alert"
     aria-live="assertive"
     class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
    <div class="flex gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
             class="w-5 h-5 text-red-500 shrink-0 mt-0.5" aria-hidden="true">
            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-red-700 mb-1">Mohon perbaiki kesalahan berikut:</p>
            <ul class="text-xs text-red-600 list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

{{-- ── Submission Form ── --}}
<form method="POST"
      action="{{ route('complaints.store') }}"
      enctype="multipart/form-data"
      novalidate
      aria-label="Formulir pengaduan">
    @csrf

    <div class="space-y-6">

        {{-- ─ Section: Identitas Pelapor ─ --}}
        <section aria-labelledby="section-identity" class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6">
            <h2 id="section-identity" class="text-base font-semibold text-slate-700 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center" aria-hidden="true">1</span>
                Identitas Pelapor
                <span class="ml-auto text-xs font-normal text-slate-400 italic">(opsional — boleh anonim)</span>
            </h2>

            <div class="grid sm:grid-cols-2 gap-4">
                {{-- Nama --}}
                <div>
                    <label for="reporter_name" class="block text-sm font-medium text-slate-700 mb-1">
                        Nama Lengkap
                    </label>
                    <input type="text"
                           id="reporter_name"
                           name="reporter_name"
                           value="{{ old('reporter_name') }}"
                           autocomplete="name"
                           placeholder="Nama Anda (opsional)"
                           aria-describedby="reporter_name_help"
                           class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition-colors
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                  @error('reporter_name') border-red-400 bg-red-50 @else border-slate-300 bg-white @enderror">
                    <p id="reporter_name_help" class="mt-1 text-xs text-slate-400">Biarkan kosong untuk melapor secara anonim.</p>
                    @error('reporter_name')
                        <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kontak --}}
                <div>
                    <label for="reporter_contact" class="block text-sm font-medium text-slate-700 mb-1">
                        Nomor HP / Email
                    </label>
                    <input type="text"
                           id="reporter_contact"
                           name="reporter_contact"
                           value="{{ old('reporter_contact') }}"
                           autocomplete="tel"
                           placeholder="08xx / email@contoh.com (opsional)"
                           aria-describedby="reporter_contact_help"
                           class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition-colors
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                  @error('reporter_contact') border-red-400 bg-red-50 @else border-slate-300 bg-white @enderror">
                    <p id="reporter_contact_help" class="mt-1 text-xs text-slate-400">Untuk dihubungi jika diperlukan klarifikasi.</p>
                    @error('reporter_contact')
                        <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Aksesibilitas Disabilitas --}}
            <div class="mt-4 p-4 rounded-xl bg-blue-50 border border-blue-100">
                <div class="flex items-start gap-3">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="checkbox"
                               id="is_disability_friendly"
                               name="is_disability_friendly"
                               value="1"
                               {{ old('is_disability_friendly') ? 'checked' : '' }}
                               aria-describedby="disability_help"
                               class="w-4 h-4 rounded border-slate-300 text-blue-600
                                      focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                    </div>
                    <div>
                        <label for="is_disability_friendly"
                               class="text-sm font-medium text-blue-800 cursor-pointer flex items-center gap-1.5">
                            Saya atau orang yang dilaporkan adalah penyandang disabilitas
                            {{-- Tooltip trigger --}}
                            <button type="button"
                                    aria-label="Penjelasan tentang layanan ramah disabilitas"
                                    aria-expanded="false"
                                    data-tooltip="true"
                                    class="w-4 h-4 rounded-full bg-blue-200 text-blue-700 text-[10px] font-bold inline-flex items-center justify-center hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors">
                                ?
                            </button>
                        </label>
                        <p id="disability_help" class="mt-1 text-xs text-blue-600 leading-relaxed">
                            Centang ini agar pengaduan Anda mendapat prioritas penanganan dan kami dapat
                            menyesuaikan layanan untuk kebutuhan aksesibilitas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─ Section: Detail Pengaduan ─ --}}
        <section aria-labelledby="section-detail" class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6">
            <h2 id="section-detail" class="text-base font-semibold text-slate-700 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center" aria-hidden="true">2</span>
                Detail Pengaduan
            </h2>

            {{-- Kategori --}}
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">
                    Kategori Pengaduan <span class="text-red-500" aria-label="wajib diisi">*</span>
                </label>
                <select id="category_id"
                        name="category_id"
                        required
                        aria-required="true"
                        class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-800 bg-white transition-colors
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               @error('category_id') border-red-400 bg-red-50 @else border-slate-300 @enderror">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>— Pilih kategori —</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1">
                    Judul Pengaduan <span class="text-red-500" aria-label="wajib diisi">*</span>
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       aria-required="true"
                       maxlength="191"
                       placeholder="Ringkasan singkat masalah Anda"
                       class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition-colors
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              @error('title') border-red-400 bg-red-50 @else border-slate-300 bg-white @enderror">
                @error('title')
                    <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                    Deskripsi Lengkap <span class="text-red-500" aria-label="wajib diisi">*</span>
                </label>
                <textarea id="description"
                          name="description"
                          rows="5"
                          required
                          aria-required="true"
                          aria-describedby="description_help"
                          placeholder="Jelaskan kejadian, lokasi, waktu, dan pihak yang terlibat secara detail..."
                          class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 resize-y transition-colors
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                 @error('description') border-red-400 bg-red-50 @else border-slate-300 bg-white @enderror">{{ old('description') }}</textarea>
                <p id="description_help" class="mt-1 text-xs text-slate-400">Minimal 20 karakter. Semakin detail, semakin mudah ditangani.</p>
                @error('description')
                    <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>
        </section>

        {{-- ─ Section: Lampiran ─ --}}
        <section aria-labelledby="section-attachments" class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6">
            <h2 id="section-attachments" class="text-base font-semibold text-slate-700 mb-1 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center" aria-hidden="true">3</span>
                Lampiran
                <span class="ml-auto text-xs font-normal text-slate-400 italic">(opsional)</span>
            </h2>
            <p class="text-xs text-slate-500 mb-4 ml-8">
                Foto atau video sebagai bukti pendukung. Maks. 5 file, masing-masing maks. 20 MB.
            </p>

            <div>
                <label for="attachments"
                       class="group relative flex flex-col items-center justify-center w-full min-h-32 rounded-xl border-2 border-dashed cursor-pointer transition-colors
                              hover:border-blue-400 hover:bg-blue-50 focus-within:border-blue-500 focus-within:bg-blue-50
                              @error('attachments') border-red-400 bg-red-50 @else border-slate-300 bg-slate-50 @enderror">
                    <input type="file"
                           id="attachments"
                           name="attachments[]"
                           multiple
                           accept="image/jpeg,image/png,image/gif,video/mp4,video/quicktime,video/x-msvideo,video/webm"
                           aria-describedby="attachments_help"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           onchange="previewFiles(this)">
                    <div class="text-center px-4 py-6 pointer-events-none" id="upload-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-8 h-8 mx-auto mb-2 text-slate-400 group-hover:text-blue-500 transition-colors" aria-hidden="true">
                            <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-medium text-slate-600 group-hover:text-blue-700">Klik atau seret file ke sini</p>
                        <p class="text-xs text-slate-400 mt-0.5">JPG, PNG, GIF, MP4, MOV — maks. 20 MB per file</p>
                    </div>
                </label>
                <p id="attachments_help" class="sr-only">Unggah hingga 5 file gambar atau video sebagai bukti pengaduan.</p>

                {{-- File Preview --}}
                <ul id="file-preview-list" class="mt-3 space-y-1.5" aria-label="Daftar file yang dipilih" aria-live="polite"></ul>

                @error('attachments')
                    <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                @enderror
                @error('attachments.*')
                    <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>
        </section>

        {{-- ─ Submit ─ --}}
        <div class="flex items-center justify-between gap-4 pt-2">
            <p class="text-xs text-slate-400">
                <span class="text-red-500">*</span> Wajib diisi
            </p>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow-sm
                           hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                           transition-all duration-150 disabled:opacity-60 disabled:cursor-not-allowed"
                    id="submit-btn"
                    aria-describedby="submit-notice">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                    <path d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z"/>
                </svg>
                Kirim Pengaduan
            </button>
        </div>
        <p id="submit-notice" class="text-xs text-slate-400 text-right">
            Dengan mengirim, Anda menyetujui bahwa informasi yang disampaikan adalah benar.
        </p>

    </div>
</form>

@endif
@endsection

@push('scripts')
<script>
    /* ── File Preview ── */
    function previewFiles(input) {
        const list = document.getElementById('file-preview-list');
        const placeholder = document.getElementById('upload-placeholder');
        list.innerHTML = '';

        if (!input.files.length) {
            placeholder.classList.remove('hidden');
            return;
        }

        placeholder.classList.add('hidden');

        Array.from(input.files).forEach((file, i) => {
            const isVideo = file.type.startsWith('video/');
            const sizeMB = (file.size / 1024 / 1024).toFixed(1);
            const li = document.createElement('li');
            li.className = 'flex items-center gap-2.5 px-3 py-2 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-700';
            li.innerHTML = `
                <span aria-hidden="true" class="text-base">${isVideo ? '🎥' : '🖼️'}</span>
                <span class="flex-1 truncate font-medium">${file.name}</span>
                <span class="text-slate-400 shrink-0">${sizeMB} MB</span>
            `;
            list.appendChild(li);
        });
    }

    /* ── Copy tracking code ── */
    function copyTrackingCode() {
        const code = document.getElementById('tracking-code-display')?.innerText?.trim();
        if (!code) return;
        navigator.clipboard.writeText(code).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Disalin!',
                html: `Kode <strong>${code}</strong> berhasil disalin ke clipboard.`,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        });
    }

    /* ── Submit loading state ── */
    document.querySelector('form')?.addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                Mengirim…
            `;
        }
    });
</script>
@endpush
