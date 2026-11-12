# Panduan Membangun `laravel-si` Berkelanjutan P01–P12

Dokumen ini menjelaskan **apa yang dikerjakan pada tiap pertemuan** dan bukti pengerjaan. Kode lengkap akhirnya ada di folder proyek. Jangan membuat proyek baru setiap pekan.

## P01 — Inisialisasi Laravel 13 & Git
**Target:** dapat mengecek PHP >=8.3, Composer, Node.js, npm, DBMS; menjalankan Artisan dan Git.

```bash
composer create-project laravel/laravel laravel-si "^13.0"
cd laravel-si
php -v
composer -V
node -v
npm -v
php artisan about
php artisan serve
```

Atur `.env` untuk SQLite atau MySQL. Initial Git: `git init && git add . && git commit -m "chore(p01): initial project"`. Proyek final dari ZIP bisa dijalankan melalui panduan Jalur A README.

**Bukti:** halaman welcome, terminal `php artisan about`, `git log --oneline`. *Jangan screenshot isi APP_KEY/.env.*

## P02 — Request Lifecycle & Routing
**Target:** jelaskan alur Browser -> `public/index.php` -> `bootstrap/app.php` -> `routes/web.php` -> Controller -> View -> Response.

1. Periksa `routes/web.php` dan resource route `mahasiswa`.
2. Periksa `app/Http/Controllers/DashboardController.php`.
3. Jalankan `php artisan route:list` lalu akses `/dashboard`.
4. Uji `/mahasiswa/999999` untuk 404.

**Latihan:** identifikasi HTTP method GET/POST/PUT/DELETE; jelaskan perbedaan middleware `auth` dan route resource. *Autentikasi final ditambahkan P09.*

## P03 — Blade + Bootstrap + Vite
**Target:** komponen UI konsisten/responsif.

1. Buka `resources/views/layouts/app.blade.php`, temukan `@yield`, `@stack`, `@vite`, dan navbar.
2. Buka `resources/views/components/mahasiswa-card.blade.php`, lihat props `$mahasiswa` dan output escaped `{{ }}`.
3. Jalankan `npm install && npm run build`.
4. Uji tampilan mobile melalui DevTools (lebar 375px) dan desktop (1280px).

**Latihan:** tambahkan komponen Blade `<x-mahasiswa-card :mahasiswa="$m" />` di halaman yang sudah memuat relasi.

## P04 — Migration, Seeder dan Factory
**Target:** membuat perubahan skema dari kode.

```bash
php artisan migrate:status
php artisan migrate
php artisan db:seed
```

Periksa migration `program_studis`, `mahasiswas`, `mata_kuliahs`, lalu `database/seeders/DatabaseSeeder.php`. Perhatikan `unique()` untuk NIM, `foreignId(...)->constrained()` untuk FK, serta indeks.

**Latihan:** tambah kolom non-sensitif menggunakan migration baru. `migrate:rollback` hanya pada database latihan yang aman untuk rollback. Hindari `migrate:fresh` jika data penting sudah ada.

## P05 — Eloquent ORM & CRUD
**Target:** satu entitas (Mahasiswa) mempunyai CRUD lengkap, pencarian, sorting, pagination.

1. Buka `MahasiswaController::index()` dan cari `where('nama','like',...)`, `orderBy('nama')`, `paginate(10)`.
2. Login admin: tambah data mahasiswa, edit NIM, lalu hapus satu data dummy.
3. Periksa `routes/web.php` dan `resources/views/mahasiswa/form.blade.php`.

**Latihan:** filter `q` berdasarkan NIM; jelaskan `$fillable` dan kapan memakai `validated()`.

## P06 — Relationship, Pivot & Optimasi Query
**Target:** `User -> Profile (hasOne)`, `ProgramStudi -> Mahasiswa (hasMany)`, `Mahasiswa <-> MataKuliah (belongsToMany)`.

1. Gambar ERD dalam `docs/ERD.md`.
2. Periksa `mahasiswa_mata_kuliah` (pivot dengan semester, tahun akademik).
3. Dalam `MahasiswaController::index`, amati `with(['programStudi','mataKuliahs'])`.
4. Ganti sementara di salinan latihan `with(...)` menjadi `all()`, akses relasi pada loop dan lihat efek N+1 menggunakan query log/debugbar yang sesuai.
5. Gunakan `withCount('mahasiswas')` di ProgramStudiController untuk agregasi.

**Bukti:** screenshot halaman detail relasi dan ringkasan perbandingan query. Kembalikan kode optimasi sesudah eksperimen.

## P07 — Validation, Session, CSRF, Error & Logging
**Target:** input validasi tidak mengubah data jika gagal, semua mutasi terlindungi CSRF.

1. Buka `StoreMahasiswaRequest.php` dan `UpdateMahasiswaRequest.php`.
2. Uji `nim` kosong dan duplikat; amati `@error` serta `old()` di Blade.
3. Uji sukses membuat data, lihat `with('success',...)` pada halaman berikutnya.
4. Praktikkan form DELETE dengan `@csrf` dan `@method('DELETE')`.
5. Uji URL tidak ada dan halaman `errors/404.blade.php`.
6. Periksa log `storage/logs/laravel.log` tanpa mencetak token/password.

**Tugas 2:** tabel kasus uji dengan kolom input, harapan, hasil nyata, PASS/FAIL.

## P08 — UTS praktik individual (tidak menambah modul)
**Materi ujian:** routing, controller, Blade, migration, Eloquent, CRUD, relasi dan validasi; lanjutkan `laravel-si` dengan studi kasus bervariasi, kerjakan sendiri, kumpulkan branch Git + screenshot yang tidak memuat rahasia. Ikuti peraturan dosen/LMS.

## P09 — Authentication, Authorization, RBAC
**Target:** daftar akun staff, login/logout, reset password; admin hanya dapat create/update/delete.

1. Periksa migrasi `add_role_to_users_table.php`, jalankan `php artisan migrate`.
2. Seed akun dummy `php artisan db:seed`.
3. Login `admin@laravel-si.test`, buat mahasiswa; logout dan login staff, periksa tombol tambah/edit hilang.
4. Coba kirim request POST menggunakan staff (bukan hanya UI) dan verifikasi 403.
5. Buka `MahasiswaPolicy.php`, `EnsureRole.php`, `AppServiceProvider.php`.
6. Uji fitur reset password menggunakan mailer `log` pada lingkungan latihan.

## P10 — File Upload & Storage Aman
**Target:** foto demonstrasi *public*, PDF *private*, akses sesuai Policy.

1. Login admin, buka detail Mahasiswa.
2. Upload foto JPG dummy (<=2MB), amati URL `/storage/...` setelah `storage:link`.
3. Upload PDF dummy (<=5MB), cek metadata `mahasiswa_dokumens`.
4. Login staff dan unduh PDF melalui route terlindungi.
5. Uji upload file `.exe`/`.txt` dan file berukuran terlalu besar; validasi wajib menolak.
6. Coba akses PDF secara langsung melalui `/storage/...`: seharusnya tidak tersedia karena disimpan di disk `local` privat.

**Bukti:** hasil validasi, izin admin/staff, tidak menampilkan isi dokumen asli.

## P11 — REST API + Sanctum
**Target:** dua entitas API, respons JSON, status code dan Bearer token.

```bash
php artisan route:list --path=api
php artisan test --filter=ApiSanctumTest
```

1. POST `/api/v1/login` dengan email/password/admin dan `device_name`.
2. Simpan token **hanya secara lokal** (Postman environment, jangan screenshot token).
3. GET `/api/v1/mahasiswa` dengan `Authorization: Bearer TOKEN`.
4. Coba POST data dengan token staff -> 403; admin -> 201 jika valid.
5. Uji input kosong -> 422, ID tidak ada -> 404, delete -> 204 jika diizinkan.
6. POST `/api/v1/logout`, verifikasi token dicabut.

## P12 — Integrasi API Eksternal Menggunakan HTTP Client
**Target:** aplikasi sebagai klien dari JSONPlaceholder, penanganan timeout/retry/fallback.

1. Buka `app/Services/ExternalPostService.php` dan `config/services.php`.
2. Login lalu akses `/referensi-posts`; coba filter `?user_id=1`, klik detail.
3. Atur `.env` `EXTERNAL_POSTS_BASE_URL=https://jsonplaceholder.typicode.com`.
4. Amati `Http::acceptJson()->connectTimeout(3)->timeout(5)->retry(2,250,throw:false)->get(...)`.
5. Simulasikan 503/koneksi gagal dengan `Http::fake` pada feature test.
6. Jalankan `php artisan test --filter=ExternalPostTest` dan catat hasil.

**Lanjutan P13:** feature/database assertions, API testing lebih luas, dokumentasi endpoint dan praktik resiliency.

---

**Aturan umum setiap pekan:** buat satu branch `pNN-topik` (jika diminta), lakukan commit deskriptif, jangan commit `.env`/token/dokumen asli, dan selalu jalankan `php artisan route:list`, `migrate:status`, tes terkait setelah perubahan.
