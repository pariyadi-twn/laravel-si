<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class MataKuliah extends Model {
 use HasFactory;
 protected $fillable = ['kode','nama','sks'];
 // [P06] Relasi many-to-many kebalikan dari Mahasiswa::mataKuliahs().
 public function mahasiswas(): BelongsToMany { return $this->belongsToMany(Mahasiswa::class)->withPivot(['semester','tahun_akademik'])->withTimestamps(); }
}
