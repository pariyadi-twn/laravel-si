# Kontrak API P11 + Integrasi P12

URL lokal: `http://127.0.0.1:8000` dan prefix versi `/api/v1`. Di `bootstrap/app.php`, `routes/api.php` sudah otomatis diberi `/api`.

## Login (dapatkan Bearer token)

```http
POST /api/v1/login HTTP/1.1
Accept: application/json
Content-Type: application/json

{"email":"admin@laravel-si.test","password":"Password123!","device_name":"postman-praktikum"}
```

Respons **200** berisi `access_token` dan `token_type: Bearer`. Token adalah **rahasia**: jangan menaruhnya di Git, README hasil pekerjaan, atau screenshot.

### Curl contoh

```bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
 -H 'Content-Type: application/json' -H 'Accept: application/json' \
 -d '{"email":"admin@laravel-si.test","password":"Password123!","device_name":"terminal-lokal"}'
```

Copy `access_token` ke environment Postman/Bruno atau variabel terminal lokal.

```bash
curl http://127.0.0.1:8000/api/v1/mahasiswa \
 -H 'Accept: application/json' -H 'Authorization: Bearer TOKEN_ANDA'
```

## Endpoint

| Method | URL | Role + token | Status normal |
|---|---|---|---|
| POST | `/api/v1/login` | guest | 200 token / 401 gagal |
| GET | `/api/v1/me` | admin/staff + token | 200 |
| POST | `/api/v1/logout` | admin/staff + token | 200 revoke |
| GET | `/api/v1/program-studi` | read | 200 |
| GET | `/api/v1/program-studi/{id}` | read | 200 / 404 |
| POST | `/api/v1/program-studi` | admin + prodi:write | 201 / 422 |
| PUT | `/api/v1/program-studi/{id}` | admin + prodi:write | 200 / 422 |
| DELETE | `/api/v1/program-studi/{id}` | admin + prodi:write | 204 / 409 |
| GET | `/api/v1/mahasiswa` | read | 200 |
| GET | `/api/v1/mahasiswa/{id}` | read | 200 / 404 |
| POST | `/api/v1/mahasiswa` | admin + mahasiswa:write | 201 / 422 |
| PUT | `/api/v1/mahasiswa/{id}` | admin + mahasiswa:write | 200 / 422 |
| DELETE | `/api/v1/mahasiswa/{id}` | admin + mahasiswa:write | 204 / 409 |
| GET | `/api/v1/referensi-posts` | read | 200 / 503 upstream |
| GET | `/api/v1/referensi-posts/{id}` | read | 200 / 404 / 503 |

**P11:** `401` tidak ada token / token tidak berlaku; `403` token valid tetapi tidak ada hak; `404` ID tidak ada; `422` field tidak valid; `409` terhalang relasi; `204` sukses tanpa body. **P12:** `503` kegagalan upstream; log tidak membocorkan rahasia.

## Contoh JSON create mahasiswa

```http
POST /api/v1/mahasiswa HTTP/1.1
Accept: application/json
Content-Type: application/json
Authorization: Bearer TOKEN_ANDA

{"nim":"F1E123999","nama":"Mahasiswa Latihan","email":"latihan@example.test","program_studi_id":1}
```

## Output API Resource

```json
{"data":{"id":1,"nim":"F1E123999","nama":"Mahasiswa Latihan","email":"latihan@example.test","telepon":null,"program_studi":{"id":1,"kode":"SI","nama":"Sistem Informasi"}}}
```

Pada koleksi paginate, respons JSON menambahkan `links` dan `meta`. Jangan gunakan response contoh sebagai data asli atau angka query nyata.

## P12 — HTTP Client eksternal

Web: `GET /referensi-posts?user_id=1`, `GET /referensi-posts/1`. API proxy: `GET /api/v1/referensi-posts`.

Kode `ExternalPostService` memakai `acceptJson`, `connectTimeout`, `timeout`, `retry(2,250,throw:false)`, cek `status()`, fallback pesan ramah, dan log tanpa token. Untuk tes gunakan `Http::fake()`, bukan mengandalkan jaringan internet.
