<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Mahasiswa extends Model {
 use HasFactory;
 protected $fillable = ['nim','nama','email','telepon','program_studi_id']; // [P05] foto_path diperbarui terpisah pada [P10].
 // [P06] Many-to-one: tiap mahasiswa milik tepat satu prodi.
 public function programStudi(): BelongsTo { return $this->belongsTo(ProgramStudi::class); }
 // [P06] Many-to-many melalui pivot dengan field semester.
 public function mataKuliahs(): BelongsToMany { return $this->belongsToMany(MataKuliah::class)->withPivot(['semester','tahun_akademik'])->withTimestamps(); }
 // [P10] Satu mahasiswa dapat memiliki beberapa PDF privat.
 public function dokumens(): HasMany { return $this->hasMany(MahasiswaDokumen::class); }
}
