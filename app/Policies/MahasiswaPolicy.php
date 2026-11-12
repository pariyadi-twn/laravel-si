<?php
namespace App\Policies;
use App\Models\Mahasiswa;
use App\Models\User;
class MahasiswaPolicy {
 // [P09] Staff boleh membaca data akademik, admin boleh CRUD/unggah.
 public function viewAny(User $user): bool { return in_array($user->role,['admin','staff'],true); }
 public function view(User $user,Mahasiswa $mahasiswa): bool { return $this->viewAny($user); }
 public function create(User $user): bool { return $user->isAdmin(); }
 public function update(User $user,Mahasiswa $mahasiswa): bool { return $user->isAdmin(); }
 public function delete(User $user,Mahasiswa $mahasiswa): bool { return $user->isAdmin(); }
}
