<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ApiSanctumTest extends TestCase {
 use RefreshDatabase;
 public function test_api_membutuhkan_token():void {
  // [P11] 401 harus muncul jika request JSON tidak membawa token.
  $this->getJson('/api/v1/program-studi')->assertUnauthorized();
 }
 public function test_staff_hanya_dapat_read_dengan_token():void {
  $prodi=ProgramStudi::factory()->create();
  $u=User::factory()->create();$u->forceFill(['role'=>'staff'])->save();
  $token=$u->createToken('test-staff',['prodi:read','mahasiswa:read'])->plainTextToken;
  $this->withToken($token)->getJson('/api/v1/program-studi')->assertOk();
  $this->withToken($token)->postJson('/api/v1/program-studi',['kode'=>'X','nama'=>'X'])->assertForbidden();
 }
 public function test_admin_bisa_membuat_prodi_dan_validasi_422():void {
  $u=User::factory()->create();$u->forceFill(['role'=>'admin'])->save();
  $token=$u->createToken('test-admin',['prodi:read','prodi:write'])->plainTextToken;
  $this->withToken($token)->postJson('/api/v1/program-studi',['kode'=>'SI','nama'=>'Sistem Informasi'])->assertCreated()->assertJsonPath('data.kode','SI');
  $this->withToken($token)->postJson('/api/v1/program-studi',['kode'=>'SI','nama'=>'Duplikat'])->assertUnprocessable()->assertJsonValidationErrors('kode');
 }
 public function test_api_logout_mencabut_token():void {
  $u=User::factory()->create();
  $token=$u->createToken('tes',['prodi:read'])->plainTextToken;
  $this->withToken($token)->postJson('/api/v1/logout')->assertOk();
  $this->withToken($token)->getJson('/api/v1/me')->assertUnauthorized();
 }
}
