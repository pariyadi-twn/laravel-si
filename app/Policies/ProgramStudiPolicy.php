<?php
namespace App\Policies;
use App\Models\ProgramStudi;
use App\Models\User;
class ProgramStudiPolicy {
 // [P09] Batasi mutasi master Program Studi di server.
 public function viewAny(User $u): bool { return in_array($u->role,['admin','staff'],true); }
 public function view(User $u,ProgramStudi $p): bool { return $this->viewAny($u); }
 public function create(User $u): bool { return $u->isAdmin(); }
 public function update(User $u,ProgramStudi $p): bool { return $u->isAdmin(); }
 public function delete(User $u,ProgramStudi $p): bool { return $u->isAdmin(); }
}
