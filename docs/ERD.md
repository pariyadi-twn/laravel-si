# ERD Proyek Praktikum `laravel-si`

Data sengaja sederhana untuk pembelajaran relasi. Prefix `Pxx` adalah pertemuan ketika konsep tersebut menjadi fokus.

```mermaid
erDiagram
    USERS ||--o| PROFILES : "punya [P06]"
    PROGRAM_STUDIS ||--o{ MAHASISWAS : "menaungi [P06]"
    MAHASISWAS ||--o{ MAHASISWA_MATA_KULIAH : "mengambil [P06]"
    MATA_KULIAHS ||--o{ MAHASISWA_MATA_KULIAH : "tercantum [P06]"
    MAHASISWAS ||--o{ MAHASISWA_DOKUMENS : "memiliki [P10]"
    USERS ||--o{ MAHASISWA_DOKUMENS : "upload [P10]"
    USERS ||--o{ PERSONAL_ACCESS_TOKENS : "token [P11]"
    USERS { bigint id PK
            string name
            string email UK
            string password
            string role "P09: admin|staff" }
    PROFILES { bigint id PK
               bigint user_id FK,UK
               string telepon
               text alamat }
    PROGRAM_STUDIS { bigint id PK
                     string kode UK
                     string nama }
    MAHASISWAS { bigint id PK
                 bigint program_studi_id FK
                 string nim UK
                 string nama
                 string foto_path "P10: disk public" }
    MATA_KULIAHS { bigint id PK
                   string kode UK
                   string nama
                   int sks }
    MAHASISWA_MATA_KULIAH { bigint mahasiswa_id FK
                            bigint mata_kuliah_id FK
                            string semester
                            string tahun_akademik }
    MAHASISWA_DOKUMENS { bigint id PK
                         bigint mahasiswa_id FK
                         bigint uploaded_by FK
                         string disk "P10: local"
                         string path }
    PERSONAL_ACCESS_TOKENS { bigint id PK
                             bigint tokenable_id
                             string token UK
                             text abilities }
```

**PK** = primary key. **FK** = foreign key. **UK** = unique index.

- **P04:** tiga tabel akademik dibuat dengan migration dan constraint.
- **P06:** `profiles.user_id` unik -> one-to-one; `mahasiswas.program_studi_id` -> one-to-many; pivot `mahasiswa_mata_kuliah` -> many-to-many.
- **P09:** users memiliki role admin/staff.
- **P10:** file disimpan di filesystem, **hanya metadata/path** berada di database. `foto_path` menunjuk disk publik sedangkan `mahasiswa_dokumens.path` disk privat.
- **P11:** Sanctum menyimpan **hash** token + abilities, tidak menyimpan token mentah.
- **P12:** JSONPlaceholder **tidak memerlukan tabel**, karena data hanya diambil secara dinamis melalui HTTP Client.
