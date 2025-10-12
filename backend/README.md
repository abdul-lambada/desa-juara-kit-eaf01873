# Backend Admin Desa Juara

Backend ini merupakan implementasi MVC ringan berbasis PHP untuk mengelola data pada proyek **Desa Juara** dengan antarmuka **SB Admin 2**.

## Prasyarat

- PHP 8.1+
- Composer
- Ekstensi PDO (MySQL/PostgreSQL sesuai kebutuhan)
- Web server (Apache/Nginx) atau PHP built-in server
- Database yang telah memiliki skema `supabase/schema.sql`

## Instalasi

1. Masuk ke direktori backend:
   ```bash
   cd backend
   ```
2. Install dependensi Composer:
   ```bash
   composer install
   ```
3. Duplikat file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:
   ```bash
   cp .env.example .env
   ```
4. Jalankan migrasi/skrip SQL sesuai skema Supabase untuk memastikan tabel tersedia.

## Menjalankan Aplikasi

Menggunakan built-in server PHP:
```bash
php -S localhost:8000 -t public
```
Akses melalui browser: `http://localhost:8000`

Jika menggunakan Apache/Nginx, arahkan document root ke direktori `public/`.

## Struktur Direktori

- **app/** – berisi core (router, view, database), controller, model, helper
- **bootstrap/** – inisialisasi aplikasi dan router
- **config/** – konfigurasi aplikasi & database
- **public/** – entry point (`index.php`) dan aset publik
- **resources/views/** – template SB Admin 2 (layouts, partials, modul)
- **routes/web.php** – definisi rute aplikasi

## Fitur Awal

- Dasbor ringkas (`HomeController`) dengan statistik total pengguna
- Modul Pengguna (`PenggunaController`) mencakup:
  - List dengan filter pencarian & status
  - Detail pengguna
  - Tambah/Ubah/Hapus pengguna (dengan validasi sederhana)
  - Flash message & penyimpanan input lama

## Menambahkan Modul Baru

1. Buat model yang merepresentasikan tabel baru di `app/Models/`.
2. Buat controller di `app/Controllers/` dengan resource method (`index`, `create`, `store`, dll).
3. Tambahkan rute di `routes/web.php` menggunakan `$router->resource()`.
4. Tambahkan view di `resources/views/<modul>/` dan gunakan layout utama `layouts.app`.
5. Sesuaikan menu pada `resources/views/partials/sidebar.php` bila perlu.

## Penyesuaian Lanjutan

- Integrasikan autentikasi Supabase melalui `auth_user_id` di model `Pengguna`.
- Tambahkan middleware/guard untuk proteksi rute.
- Implementasikan pagination server-side sesuai kebutuhan UI.
- Gunakan chart atau komponen tambahan SB Admin 2 untuk statistik lainnya.
