<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P04] Migration + unique index: kode prodi tidak boleh sama.
  Schema::create('program_studis', function (Blueprint $t): void {
   $t->id(); $t->string('kode', 20)->unique(); $t->string('nama', 120);
   $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('program_studis'); }
};
