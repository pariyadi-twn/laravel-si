<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  // [P04] Seeder aman untuk praktikum: gunakan hanya data FIKTIF.
  // [P09] Password contoh wajib diganti untuk deployment nyata.
  $admin=User::updateOrCreate(['email'=>'admin@laravel-si.test'],['name'=>'Admin Praktikum','password'=>Hash::make('Password123!')]);
  $admin->forceFill(['role'=>'admin'])->save(); // [P09] Role ditetapkan server, bukan form registrasi.
  $staff=User::updateOrCreate(['email'=>'staff@laravel-si.test'],['name'=>'Staff Praktikum','password'=>Hash::make('Password123!')]);
  $staff->forceFill(['role'=>'staff'])->save();
  $admin->profile()->firstOrCreate([],['telepon'=>'081200000001','alamat'=>'Alamat dummy']);
  $staff->profile()->firstOrCreate([],['telepon'=>'081200000002','alamat'=>'Alamat dummy']);
  foreach([['SI','Sistem Informasi'],['IF','Informatika'],['TE','Teknik Elektro']] as [$kode,$nama]) {
   ProgramStudi::firstOrCreate(['kode'=>$kode],['nama'=>$nama]);
  }
  foreach([['SI301','Pemrograman Berbasis Web Lanjut'],['SI302','Basis Data'],['SI303','Sistem Cerdas'],['SI304','Rekayasa Perangkat Lunak'],['SI305','Pemrograman Berorientasi Objek']] as [$kode,$nama]) {
   MataKuliah::firstOrCreate(['kode'=>$kode],['nama'=>$nama,'sks'=>3]);
  }
  // [P04-P06] Data mahasiswa dalam jumlah cukup untuk latihan pagination dan N+1.
  if (Mahasiswa::count() === 0) {
   $prodis=ProgramStudi::pluck('id'); $mkIds=MataKuliah::pluck('id')->all();
   foreach(range(1,36) as $i) {
    $m=Mahasiswa::factory()->create(['program_studi_id'=>$prodis[($i-1)%$prodis->count()]]);
    foreach(array_slice($mkIds, 0, ($i % 3)+1) as $id) {
     $m->mataKuliahs()->attach($id,['semester'=>'Ganjil','tahun_akademik'=>'2026/2027']);
    }
   }
  }
 }
}
