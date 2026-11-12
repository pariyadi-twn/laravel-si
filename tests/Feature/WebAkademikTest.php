<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Testing\RefreshDatabase;
class WebAkademikTest extends TestCase {
 use RefreshDatabase;
 public function test_staff_dapat_membaca_tetapi_tidak_boleh_membuat_mahasiswa():void {
  // [P05] CRUD, [P07] validasi, [P09] Policy.
  $prodi=ProgramStudi::factory()->create();
  $u=User::factory()->create();$u->forceFill(['role'=>'staff'])->save();
  $this->actingAs($u)->get('/mahasiswa')->assertOk();
  $this->actingAs($u)->post('/mahasiswa',['nim'=>'123','nama'=>'Tes','program_studi_id'=>$prodi->id,'semester'=>'Ganjil','tahun_akademik'=>'2026/2027'])->assertForbidden();
 }
 public function test_admin_bisa_menambah_dan_nim_duplikat_ditolak():void {
  $prodi=ProgramStudi::factory()->create();
  $u=User::factory()->create();$u->forceFill(['role'=>'admin'])->save();
  $data=['nim'=>'F1E123999','nama'=>'Mahasiswa Contoh','program_studi_id'=>$prodi->id,'semester'=>'Ganjil','tahun_akademik'=>'2026/2027'];
  $this->actingAs($u)->post('/mahasiswa',$data)->assertRedirect(route('mahasiswa.index'));
  $this->assertDatabaseHas('mahasiswas',['nim'=>'F1E123999']);
  $this->actingAs($u)->post('/mahasiswa',$data)->assertSessionHasErrors(['nim']);
 }
 public function test_mahasiswa_dengan_relasi_prodi_dan_matakuliah():void {
  // [P06] Eloquent relationship dihasilkan migration dan dipakai Eloquent.
  $p=ProgramStudi::factory()->create();
  $m=Mahasiswa::factory()->create(['program_studi_id'=>$p->id]);
  $this->assertSame($p->id,$m->programStudi->id);
  $this->assertCount(1,$p->mahasiswas);
 }
}
