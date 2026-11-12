<?php
namespace App\Providers;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use App\Policies\MahasiswaPolicy;
use App\Policies\ProgramStudiPolicy;
use App\Policies\MataKuliahPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void
    {
        // [P09] Pendaftaran Policy: keputusan akses selalu diverifikasi server.
        Gate::policy(Mahasiswa::class, MahasiswaPolicy::class);
        Gate::policy(ProgramStudi::class, ProgramStudiPolicy::class);
        Gate::policy(MataKuliah::class, MataKuliahPolicy::class);
        Gate::define('admin-area', fn ($user): bool => $user->isAdmin());
    }
}
