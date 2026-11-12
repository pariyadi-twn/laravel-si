<?php
// [P09] Autentikasi, middleware RBAC dan/atau Policy.
namespace App\Policies;
use App\Models\User;
use App\Models\MataKuliah;
class MataKuliahPolicy {
 public function viewAny(User $u): bool { return in_array($u->role,['admin','staff'],true); }
 public function view(User $u,MataKuliah $m): bool { return $this->viewAny($u); }
 public function create(User $u): bool { return $u->isAdmin(); }
 public function update(User $u,MataKuliah $m): bool { return $u->isAdmin(); }
 public function delete(User $u,MataKuliah $m): bool { return $u->isAdmin(); }
}
