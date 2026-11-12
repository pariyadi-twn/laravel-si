<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P10] Simpan path, bukan isi binary foto di database.
  Schema::table('mahasiswas', fn(Blueprint $t) => $t->string('foto_path')->nullable());
 }
 public function down(): void { Schema::table('mahasiswas', fn(Blueprint $t) => $t->dropColumn('foto_path')); }
};
