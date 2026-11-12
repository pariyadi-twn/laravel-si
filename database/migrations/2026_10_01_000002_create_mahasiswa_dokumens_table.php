<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P10] Metadata PDF privat; actual file ada di storage/app/private.
  Schema::create('mahasiswa_dokumens', function (Blueprint $t): void {
   $t->id();
   $t->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
   $t->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
   $t->string('kategori',60); $t->string('nama_asli',255);
   $t->string('disk',20)->default('local'); $t->string('path',500);
   $t->string('mime_type',100); $t->unsignedBigInteger('ukuran');
   $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('mahasiswa_dokumens'); }
};
