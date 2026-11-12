<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  // [P04] User bawaan diperlukan ketika [P09] autentikasi dimulai.
  Schema::create('users', function (Blueprint $t): void {
   $t->id(); $t->string('name'); $t->string('email')->unique();
   $t->timestamp('email_verified_at')->nullable(); $t->string('password');
   $t->rememberToken(); $t->timestamps();
  });
  Schema::create('password_reset_tokens', function (Blueprint $t): void {
   $t->string('email')->primary(); $t->string('token'); $t->timestamp('created_at')->nullable();
  });
 }
 public function down(): void { Schema::dropIfExists('password_reset_tokens'); Schema::dropIfExists('users'); }
};
