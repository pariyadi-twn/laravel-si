<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P04] foreignId untuk relasi [P06] one-to-many ProgramStudi -> Mahasiswa.
  Schema::create('mahasiswas', function (Blueprint $t): void {
   $t->id();
   $t->foreignId('program_studi_id')->constrained('program_studis')->restrictOnDelete();
   $t->string('nim', 20)->unique(); $t->string('nama', 120);
   $t->string('email', 120)->nullable()->unique();
   $t->string('telepon', 25)->nullable(); $t->timestamps();
   $t->index(['program_studi_id','nama']); // [P06] Indeks filter/sorting.
  });
 }
 public function down(): void { Schema::dropIfExists('mahasiswas'); }
};
