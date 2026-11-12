<?php
// [P07] Terjemahan validasi dasar untuk UI pemula; pesan khusus juga ada di Form Request.
return [
 'required'=>'Kolom :attribute wajib diisi.',
 'string'=>'Kolom :attribute harus berupa teks.',
 'integer'=>'Kolom :attribute harus berupa bilangan bulat.',
 'email'=>'Kolom :attribute harus berupa alamat email yang valid.',
 'unique'=>'Nilai :attribute sudah digunakan.',
 'exists'=>'Pilihan :attribute tidak tersedia.',
 'max'=>['string'=>'Panjang :attribute maksimum :max karakter.','file'=>'Ukuran :attribute maksimum :max KB.'],
 'min'=>['string'=>'Panjang :attribute minimum :min karakter.'],
 'confirmed'=>'Konfirmasi :attribute tidak sama.',
 'file'=>'Kolom :attribute harus berupa berkas.',
 'mimes'=>'Jenis berkas :attribute tidak diizinkan. Format: :values.',
 'mimetypes'=>'MIME berkas :attribute tidak diizinkan.',
 'between'=>['numeric'=>'Nilai :attribute harus antara :min dan :max.'],
 'attributes'=>['nim'=>'NIM','nama'=>'nama','program_studi_id'=>'program studi','email'=>'email','foto'=>'foto','dokumen'=>'dokumen'],
];
