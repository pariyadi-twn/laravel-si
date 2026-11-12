# LARAVEL-SI — Source Code Praktikum P01–P12

**Mata kuliah:** Pemrograman Berbasis Web Lanjut (ISP444), Program Studi Sistem Informasi, FST Universitas Jambi.  
**Teknologi:** Laravel **13.x**, PHP **8.3+**, Composer, Node.js/npm, Bootstrap 5.3, Vite, SQLite atau MySQL/MariaDB, Git dan Laravel Sanctum.

> Paket ini adalah **source code satu proyek terpadu** sebagai contoh pembelajaran Pertemuan 1–12. Kode dipenuhi komentar `[P01]` s.d. `[P12]` yang menerangkan konteks materi. **P08 adalah UTS**, tidak menambah modul produksi. Tidak disertakan `vendor/`, `node_modules/`, `.env`, `composer.lock`, dan hasil build karena dependensi harus dipasang di komputer masing-masing.
>
> **Perhatian:** lingkungan pembuat paket tidak memiliki Composer, koneksi Packagist, serta ekstensi SQLite yang dibutuhkan untuk menjalankan proyek. Seluruh `.php` diperiksa dengan `php -l`, tetapi pengujian end-to-end *belum* dapat dilakukan. Setelah `composer install` dan `npm install`, jalankan semua tes sesuai panduan.

## 1. Mulai dari awal — Buat proyek

Ada **dua jalur**, pilih **salah satu** saja:

### Jalur A — Jalankan source yang telah disiapkan (paling mudah)

1. Ekstrak ZIP sampai ada folder **`laravel-si/`**.
2. Buka folder `laravel-si` di VS Code dan jalankan perintah berikut pada terminalnya.

```bash
cd laravel-si
php -v            # minimal PHP 8.3
composer -V
node -v
npm -v
composer install  # unduh dependensi Laravel 13 dan Sanctum
```

**Windows PowerShell:**

```powershell
Copy-Item .env.example .env
New-Item -ItemType File database/database.sqlite -Force
```

**Linux / macOS / Git Bash:**

```bash
cp .env.example .env
mkdir -p database
touch database/database.sqlite
```

Kemudian (semua OS):

```bash
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan storage:link
php artisan route:list
php artisan test
php artisan serve
```

Buka `http://127.0.0.1:8000`. Login memakai akun **dummy** di bawah. Internet dibutuhkan saat `composer install`, `npm install`, dan untuk halaman referensi API eksternal; tes HTTP Client memakai `Http::fake` tidak memerlukan internet.

### Jalur B — Berlatih membuat Laravel 13 dari kosong (P01)

Di folder kerja kosong (sebelum mengekstrak source):

```bash
composer create-project laravel/laravel laravel-si "^13.0"
cd laravel-si
php artisan about
```

Lalu **gabungkan** file modul dari folder source ZIP ini ke proyek baru dengan teliti, terutama `routes/`, `app/`, `resources/`, `database/`, `bootstrap/app.php`, `composer.json`, dan `package.json`. Jika tidak ingin proses penggabungan manual, pakai **Jalur A**.

> Saat menyatukan proyek dengan pekerjaan sendiri, **jangan menimpa `.env`, migrasi lama, data pribadi atau branch utama tanpa backup**. `migrate:fresh` akan menghapus seluruh tabel dan data lokal, sehingga hanya untuk lingkungan praktikum yang benar-benar boleh direset.

## 2. Akun dummy lokal — hanya untuk praktikum

| Hak akses | Email | Password | Keterangan |
|---|---|---|---|
| admin | `admin@laravel-si.test` | `Password123!` | CRUD, unggah foto/PDF dan API write |
| staff | `staff@laravel-si.test` | `Password123!` | Melihat data, unduh PDF dengan Policy, API read |

Data hanya untuk lingkungan **localhost**. Ganti semua kredensial jika digunakan di server publik. Registrasi `/register` selalu menghasilkan role `staff`; user tidak dapat memilih role admin.

## 3. Peta kompetensi P01–P12

| Pertemuan | Materi inti | File contoh utama |
|---|---|---|
| P01 | PHP/Composer/Vite/Artisan/environment/Git | `.env.example`, `composer.json`, `artisan`, `docs/PANDUAN_PER_PERTEMUAN.md` |
| P02 | Request lifecycle, routing, controller, middleware | `public/index.php`, `routes/web.php`, `DashboardController.php` |
| P03 | Blade component, layout, Vite, Bootstrap | `resources/views/layouts/app.blade.php`, `resources/views/components/`, `resources/css/app.css` |
| P04 | Database migration, factory, seeder, constraint | `database/migrations/`, `database/factories/`, `DatabaseSeeder.php` |
| P05 | Eloquent ORM, CRUD, filter, pagination | `MahasiswaController.php`, `resources/views/mahasiswa/` |
| P06 | Relasi, pivot, eager loading, N+1, aggregate | `app/Models/`, pivot migration, `docs/ERD.md` |
| P07 | Form Request, CSRF, session, error, log | `app/Http/Requests/`, `resources/views/errors/`, `config/logging.php` |
| P08 | UTS praktik individual | `docs/PANDUAN_PER_PERTEMUAN.md` (tanpa fitur baru) |
| P09 | Authentication, Gate, Policy, RBAC | `AuthController`, `PasswordResetController`, `Policies/`, role migration |
| P10 | Public/private storage, upload & download aman | `MahasiswaFileController`, requests upload, migration dokumen |
| P11 | REST API, Resource, Sanctum, JSON status | `routes/api.php`, `app/Http/Controllers/Api/V1/`, `app/Http/Resources/` |
| P12 | HTTP Client eksternal, timeout/retry/fallback | `ExternalPostService`, `ExternalPostController`, `tests/Feature/ExternalPostTest.php` |

**P13–P16 belum termasuk**; P12 sudah menyertakan pengenalan `Http::fake` sebagai persiapan pembahasan pengujian pada P13.

## 4. Skenario lengkap yang dihasilkan

- **Dashboard**: `/dashboard` menunjukkan statistik dan satu profil user ([P06] one-to-one).
- **Mahasiswa**: `/mahasiswa` mengelola CRUD dengan search, pagination dan relasi Program Studi + Mata Kuliah (pivot semester/tahun akademik).
- **Program Studi**: `/program-studi` dengan penolakan delete jika masih ada mahasiswa.
- **Mata Kuliah**: `/mata-kuliah` dengan relasi many-to-many dan jumlah mahasiswa.
- **Validasi**: NIM unik, field wajib, pesan error dan flash session. Semua form mutasi memerlukan CSRF.
- **RBAC**: admin dapat menulis; staff hanya membaca. Semua server controller mengecek Gate/Policy.
- **Storage aman**: foto dummy di `storage/app/public` (public URL); PDF privat di `storage/app/private` (download melalui route terproteksi).
- **REST API**: `/api/v1/login`, `/api/v1/me`, `/api/v1/logout`, `/api/v1/mahasiswa`, `/api/v1/program-studi`.
- **HTTP Client**: `/referensi-posts` menarik data fiktif `https://jsonplaceholder.typicode.com/posts`.

## 5. Penggunaan Git dari awal (P01 & P06)

```bash
git init
git add .
git commit -m "chore(p01): inisialisasi Laravel SI"
git switch -c pertemuan-06-relasi
# Setelah menyelesaikan perubahan yang relevan:
git add app database resources routes
git commit -m "feat(p06): relasi mahasiswa-matakuliah"
```

Jangan mengunggah `.env`, password produksi, file asli mahasiswa, PDF privat atau Bearer token pada repository. P08 dapat menggunakan branch terpisah `uts-<nim>`.

## 6. Menguji dengan perintah Artisan

```bash
php artisan about
php artisan migrate:status
php artisan route:list --except-vendor
php artisan route:list --path=api
php artisan test
php artisan test --filter=ApiSanctumTest
php artisan test --filter=ExternalPostTest
```

Saat `php artisan test`, database **SQLite `:memory:`** digunakan (konfigurasi `phpunit.xml`); PHP memerlukan `pdo_sqlite`, selain ekstensi standar PHP/Laravel. Untuk produksi, uji serta sesuaikan server, queue, session, security hardening dan data personal. Aplikasi ini **ditujukan untuk pembelajaran**, bukan sistem akademik produksi.

## 7. Jika terjadi masalah

| Error | Pemeriksaan |
|---|---|
| `vendor/autoload.php not found` | Jalankan `composer install` dari root project |
| `No application encryption key` | Salin `.env.example` menjadi `.env`, lalu `php artisan key:generate` |
| `could not find driver` | Aktifkan PHP `pdo_sqlite` atau `pdo_mysql` sesuai `.env` |
| `Vite manifest not found` | `npm install` lalu `npm run build` |
| `Table ... doesn't exist` | `php artisan migrate --seed` dan `php artisan migrate:status` |
| `403` saat upload/create | Login menggunakan akun admin; staff hanya baca |
| `419 Page Expired` | Periksa `@csrf`, session, domain dan cookie; segarkan halaman |
| `401` pada `/api/v1/...` | Kirim `Authorization: Bearer TOKEN` dan `Accept: application/json` |
| `422` pada API | Periksa field JSON wajib dan aturan `unique/exists` |
| `Storage link` tidak tampil | `php artisan storage:link`; periksa izin dan disk `public` |
| `503` data eksternal | Periksa internet, base URL JSONPlaceholder, log; tes `Http::fake` tetap offline |

## 8. Isi dokumentasi tambahan

Buka `docs/PANDUAN_PER_PERTEMUAN.md` untuk **langkah P01–P12 dan milestone Git**, `docs/ERD.md` untuk diagram relasi, `docs/API.md` untuk contoh curl/JSON, `docs/MATRIKS_UJI.md` untuk rubric pengujian, dan `docs/PETA_KOMENTAR.md` untuk memahami komentar kode.

Referensi resmi: <https://laravel.com/docs/13.x>, <https://laravel.com/docs/13.x/sanctum>, <https://laravel.com/docs/13.x/filesystem>, <https://laravel.com/docs/13.x/http-client>. Semua perintah memakai Laravel 13, bukan kode lama `Auth::routes()` / `laravel/ui`.
