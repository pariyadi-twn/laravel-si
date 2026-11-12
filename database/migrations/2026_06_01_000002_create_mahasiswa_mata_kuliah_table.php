<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P06] Pivot many-to-many, simpan atribut tambahan semester/tahun akademik.
  Schema::create('mahasiswa_mata_kuliah', function (Blueprint $t): void {
   $t->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
   $t->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();
   $t->string('semester',10)->default('Ganjil');
   $t->string('tahun_akademik',9)->default('2026/2027'); $t->timestamps();
   $t->primary(['mahasiswa_id','mata_kuliah_id']);
  });
 }
 public function down(): void { Schema::dropIfExists('mahasiswa_mata_kuliah'); }
};
