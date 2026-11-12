# Matriks Pengujian Integrasi P01–P12

Isi kolom **Aktual** saat menjalankan di komputer mahasiswa. Status PASS/FAIL jangan diisi berdasarkan asumsi.

| ID | Pertemuan | Langkah uji | Hasil yang diharapkan | Aktual | PASS/FAIL |
|---|---|---|---|---|---|
| T01 | P01 | `php artisan about` | Laravel 13, PHP 8.3+ | | |
| T02 | P02 | `php artisan route:list` | Route web terdaftar | | |
| T03 | P03 | Resize 375px, menu navbar | Layout responsif | | |
| T04 | P04 | `php artisan migrate:status` | Semua migration dijalankan | | |
| T05 | P05 | Admin tambah mahasiswa valid | Data tersimpan dan redirect | | |
| T06 | P06 | Detail mahasiswa | Prodi dan MK pivot muncul | | |
| T07 | P06 | Bandingkan lazy/eager load | Query eager lebih sedikit pada N+1 | | |
| T08 | P07 | NIM kosong/duplikat | Form Request menolak dengan pesan | | |
| T09 | P07 | POST tanpa token CSRF | Ditolak 419; lakukan hanya di lingkungan latihan | | |
| T10 | P09 | Staff akses POST mahasiswa | HTTP 403 | | |
| T11 | P09 | Logout | Session invalid | | |
| T12 | P10 | Upload `.exe` | Ditolak validasi | | |
| T13 | P10 | Unduh PDF sebagai staff terautentikasi | File hanya via route, bukan public URL | | |
| T14 | P11 | GET API tanpa Bearer | HTTP 401 | | |
| T15 | P11 | Staff POST prodi dengan token read | HTTP 403 | | |
| T16 | P11 | Admin POST prodi valid | HTTP 201 | | |
| T17 | P11 | NIM API duplikat | HTTP 422 dengan errors | | |
| T18 | P11 | Hapus prodi dengan mahasiswa | HTTP 409 | | |
| T19 | P11 | DELETE record tanpa dependen | HTTP 204 | | |
| T20 | P12 | Upstream 200 via Http::fake | Artikel muncul | | |
| T21 | P12 | Upstream 503 via Http::fake | Pesan fallback, bukan trace | | |

**Bukti minimal:** URL fitur, source code, perintah test, expected vs actual, `git log --oneline`. Jangan mempublikasikan screenshot token, password, isi `.env`, atau PDF privat.
