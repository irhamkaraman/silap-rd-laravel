<div align="center">

<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel">

# SILAP-RD

### Sistem Informasi Layanan Pengaduan Ramah Disabilitas

*Platform pengaduan publik yang inklusif, aksesibel, dan berpihak pada penyandang disabilitas.*

[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v5-F59E0B?style=flat-square&logo=filament&logoColor=white)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-22C55E?style=flat-square)](LICENSE)

</div>

---

## ✨ Tentang Proyek

**SILAP-RD** adalah sistem informasi berbasis web yang memungkinkan masyarakat — terutama penyandang disabilitas — untuk menyampaikan pengaduan terkait layanan publik secara aman, mudah, dan transparan.

Sistem ini terdiri dari dua sisi:

- **🌐 Portal Publik** — Formulir pengaduan yang aksesibel (A11y-compliant), dapat diisi anonim, dilengkapi pelacakan status real-time via kode unik.
- **🛡️ Panel Admin** — Dasbor berbasis Filament v5 untuk manajemen pengaduan, penugasan instansi, pemberian respons, dan pelaporan statistik.

---

## 🏗️ Arsitektur & Stack

| Layer | Teknologi |
|---|---|
| **Backend** | Laravel 11 · PHP 8.3 |
| **Admin Panel** | Filament v5 |
| **Frontend** | Blade · Tailwind CSS v4 (via Vite) |
| **Database** | MySQL / MariaDB |
| **Storage** | Laravel Filesystem (`storage/public`) |
| **Notifikasi UI** | SweetAlert2 (CDN) |

### Pola Arsitektur

```
app/
├── Actions/                    # Business logic (StoreComplaintAction)
├── Http/
│   ├── Controllers/            # Thin controllers — hanya inject & return
│   └── Requests/               # Form validation (StoreComplaintRequest, TrackComplaintRequest)
├── Models/                     # Eloquent models dengan relasi & cast
└── Filament/
    ├── Resources/              # Admin resources (Category, Agency, Complaint)
    └── Widgets/                # Dashboard stats widget
```

---

## 🗄️ Skema Database

```
users ──────────────────────────────────── complaint_responses
categories ──┐                                      ▲
             ├──── complaints ────────────────── user_id
agencies ────┘         │
                       └──── complaint_attachments
```

| Tabel | Deskripsi |
|---|---|
| `categories` | Master kategori pengaduan |
| `agencies` | Instansi/dinas penanganan |
| `complaints` | Pengaduan (UUID, kode unik, status enum) |
| `complaint_attachments` | Lampiran gambar/video |
| `complaint_responses` | Riwayat respons petugas (timeline) |

---

## 🚀 Cara Instalasi

### Prasyarat

- PHP ≥ 8.3
- Composer
- Node.js ≥ 20
- MySQL / MariaDB

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/<username>/silapradi.git
cd silapradi

# 2. Install dependencies
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Isi konfigurasi database di .env
# DB_DATABASE=silapradi
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi & seeder
php artisan migrate:fresh --seed

# 6. Buat symlink storage
php artisan storage:link

# 7. Build aset frontend
npm run build
```

### Jalankan Aplikasi

```bash
# Development (Laravel server + Vite hot-reload secara bersamaan)
composer run dev

# Atau secara terpisah:
php artisan serve
npm run dev
```

---

## 🔑 Akun Default

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@silap.com` | `password` |

> ⚠️ Ganti password default sebelum deploy ke production.

---

## 🔗 URL Aplikasi

| Halaman | URL |
|---|---|
| Portal Publik — Buat Pengaduan | `/pengaduan/buat` |
| Portal Publik — Lacak Pengaduan | `/pengaduan/lacak` |
| Admin Panel | `/admin` |

---

## 📋 Fitur Utama

### Portal Publik

- **Formulir Pengaduan Aksesibel** — Memenuhi standar A11y (ARIA roles, label, kontras warna tinggi, skip-to-content)
- **Anonim atau Beridentitas** — Pelapor bebas memilih
- **Penanda Disabilitas** — Checkbox khusus untuk pengaduan terkait disabilitas, mendapat prioritas penanganan
- **Lampiran Multi-File** — Upload hingga 5 gambar/video (maks. 20 MB/file)
- **Kode Pengaduan Unik** — Format `SILAP-YYYYMMDD-XXXXX`, mudah dikomunikasikan secara lisan
- **Halaman Pelacakan** — Input kode → tampil status + timeline respons vertikal

### Panel Admin

- **Dashboard Stats** — 4 stat card dengan polling otomatis 30 detik (Total, Menunggu, Diproses, Selesai)
- **Manajemen Pengaduan** — Tabel dengan badge status berwarna, filter, pencarian
- **Infolist View** — Tampilan detail lengkap dengan layout terstruktur (grid + section)
- **Status Actions** — Tombol kontekstual: *Proses*, *Selesaikan*, *Tolak* — dengan modal konfirmasi
- **Riwayat Respons** — RelationManager untuk menambah update; `user_id` diisi otomatis dari sesi admin
- **Master Data** — CRUD Kategori (dengan live slug) dan Instansi

---

## 📁 Struktur File Kunci

```
app/
├── Actions/
│   └── StoreComplaintAction.php       # Generate tracking code, simpan complaint, handle upload
├── Http/
│   ├── Controllers/
│   │   └── GuestComplaintController.php   # Thin controller (4 method)
│   └── Requests/
│       ├── StoreComplaintRequest.php      # Validasi form pengaduan
│       └── TrackComplaintRequest.php      # Validasi kode lacak
├── Models/
│   ├── Complaint.php                  # UUID, status enum, relasi
│   ├── ComplaintAttachment.php
│   ├── ComplaintResponse.php
│   ├── Category.php
│   └── Agency.php
└── Filament/
    ├── Resources/
    │   ├── Complaints/
    │   │   ├── ComplaintResource.php
    │   │   ├── Pages/ViewComplaint.php    # Status actions
    │   │   ├── RelationManagers/
    │   │   │   └── ResponsesRelationManager.php
    │   │   ├── Schemas/
    │   │   │   ├── ComplaintForm.php      # Read-only form
    │   │   │   └── ComplaintInfolist.php  # Rich infolist layout
    │   │   └── Tables/ComplaintsTable.php
    │   ├── Categories/
    │   └── Agencies/
    └── Widgets/
        └── ComplaintStatsWidget.php       # StatsOverview + polling

resources/views/
├── layouts/guest.blade.php             # Layout publik + SweetAlert2 minimalis
└── complaints/
    ├── create.blade.php                # Formulir pengaduan (3 section)
    └── track.blade.php                 # Halaman lacak + timeline

routes/web.php                          # /pengaduan/buat, /pengaduan/lacak
database/seeders/
├── DatabaseSeeder.php
├── CategorySeeder.php
└── AgencySeeder.php
```

---

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test --compact

# Atau via Pest langsung
vendor/bin/pest
```

---

## 🤝 Kontribusi

Kontribusi sangat terbuka! Silakan buka [issue](../../issues) atau kirim pull request.

1. Fork repository ini
2. Buat branch fitur: `git checkout -b feature/nama-fitur`
3. Commit perubahan: `git commit -m 'feat: tambah fitur X'`
4. Push ke branch: `git push origin feature/nama-fitur`
5. Buka Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<div align="center">

Dibangun dengan ❤️ untuk masyarakat yang inklusif dan berkeadilan.

</div>
