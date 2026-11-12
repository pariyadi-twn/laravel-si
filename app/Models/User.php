<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
 use HasApiTokens, HasFactory, Notifiable; // [P11] Personal access token Sanctum.
 protected $fillable = ['name','email','password']; // [P09] ROLE bukan mass-assignable!
 protected $hidden = ['password','remember_token'];
 protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; }
 // [P09] RBAC: staff hanya baca, admin dapat mengubah data.
 public function isAdmin(): bool { return $this->role === 'admin'; }
 public function isStaff(): bool { return $this->role === 'staff'; }
 // [P06] One-to-one user - profile.
 public function profile(): HasOne { return $this->hasOne(Profile::class); }
}
