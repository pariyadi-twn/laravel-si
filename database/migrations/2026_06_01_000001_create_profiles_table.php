<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P06] unique() memastikan hubungan User <-> Profile tepat one-to-one.
  Schema::create('profiles', function (Blueprint $t): void {
   $t->id(); $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
   $t->string('telepon',25)->nullable(); $t->text('alamat')->nullable(); $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('profiles'); }
};
