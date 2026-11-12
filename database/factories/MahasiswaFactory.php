<?php
// [P04] Factory/seeder data uji terstruktur.
namespace Database\Factories;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;
class MahasiswaFactory extends Factory {
 protected $model=Mahasiswa::class;
 public function definition(): array { return [
   'nim'=>fake()->unique()->numerify('2026#####'), 'nama'=>fake()->name(),
   'email'=>fake()->unique()->safeEmail(), 'telepon'=>fake()->numerify('08##########'),
   'program_studi_id'=>ProgramStudi::factory(),
  ]; }
}
