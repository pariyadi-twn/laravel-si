<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MahasiswaDokumen extends Model {
 protected $fillable=['uploaded_by','kategori','nama_asli','disk','path','mime_type','ukuran'];
 // [P10] Metadata terhubung ke mahasiswa, file disimpan privat di disk local.
 public function mahasiswa(): BelongsTo { return $this->belongsTo(Mahasiswa::class); }
}
