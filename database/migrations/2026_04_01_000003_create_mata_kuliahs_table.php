<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P04] Skema mata kuliah, digunakan pada [P06] many-to-many.
  Schema::create('mata_kuliahs', function (Blueprint $t): void {
   $t->id(); $t->string('kode', 20)->unique(); $t->string('nama', 120);
   $t->unsignedTinyInteger('sks')->default(3); $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('mata_kuliahs'); }
};
