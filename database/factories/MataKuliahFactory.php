<?php
// [P04] Factory/seeder data uji terstruktur.
namespace Database\Factories;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;
class MataKuliahFactory extends Factory {
 protected $model=MataKuliah::class;
 public function definition(): array { return ['kode'=>'MK'.fake()->unique()->numerify('####'), 'nama'=>'Mata Kuliah '.fake()->words(2,true), 'sks'=>3]; }
}
