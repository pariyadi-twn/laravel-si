# Konvensi Komentar pada Source Code

Cari dengan pencarian VS Code, misalnya `Ctrl+Shift+F` dan kata **`[P06]`**.

| Tag | Materi spesifik | Contoh file |
|---|---|---|
| `[P01]` | Setup Composer, environment, Artisan, Git | `artisan`, `.env.example`, README |
| `[P02]` | HTTP request lifecycle, routing, controller | `public/index.php`, `routes/web.php` |
| `[P03]` | Blade layout/component, Bootstrap, Vite | `resources/views/layouts`, `components`, `resources/js` |
| `[P04]` | Database migration, constraint, factory, seeding | `database/migrations`, `DatabaseSeeder` |
| `[P05]` | Model Eloquent, CRUD, search, pagination | `MahasiswaController::index`, model `$fillable` |
| `[P06]` | 1–1, 1–N, N–N, pivot, eager loading, count | Models `User`, `Mahasiswa`, `MataKuliah` |
| `[P07]` | Form Request, CSRF, old(), flash, logging, error | `Http/Requests`, `layouts/app.blade.php` |
| `[P08]` | UTS individual, tidak menambah fitur source | `docs/PANDUAN_PER_PERTEMUAN.md` |
| `[P09]` | Session auth, role admin/staff, Gate, Policy | `AuthController`, `app/Policies`, role migration |
| `[P10]` | File upload, validasi, private/public disk, download | `MahasiswaFileController`, `config/filesystems.php` |
| `[P11]` | API JSON, Sanctum token abilities, API Resource | `routes/api.php`, `Api/V1` controllers |
| `[P12]` | HTTP Client external API, timeout, retry, fallback, fake | `ExternalPostService`, tests |

Komentar memakai bentuk `// [Pxx]` di PHP, `{{-- [Pxx] --}}` di Blade, `/* [Pxx] */` di CSS, dan `# [Pxx]` di shell/markdown jika relevan. Satu file boleh mencakup beberapa pertemuan karena project *berkelanjutan*.
