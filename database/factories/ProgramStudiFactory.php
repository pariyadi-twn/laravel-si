<?php
// [P04] Factory/seeder data uji terstruktur.
namespace Database\Factories;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProgramStudiFactory extends Factory {
 protected $model=ProgramStudi::class;
 public function definition(): array { return ['kode'=>'PS-'.fake()->unique()->numerify('####'),'nama'=>'Prodi Demo '.fake()->words(2,true)]; }
}
