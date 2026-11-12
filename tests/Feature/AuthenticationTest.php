<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthenticationTest extends TestCase {
 use RefreshDatabase;
 public function test_guest_dialihkan_ke_login():void { $this->get('/dashboard')->assertRedirect('/login'); }
 public function test_login_logout_menggunakan_session():void {
  // [P09] Login web menggunakan cookie session; bukan Bearer API.
  $u=User::factory()->create(['email'=>'tester@example.test']);
  $u->forceFill(['role'=>'staff'])->save();
  $this->post('/login',['email'=>'tester@example.test','password'=>'Password123!'])->assertRedirect(route('dashboard'));
  $this->assertAuthenticatedAs($u);
  $this->post('/logout')->assertRedirect(route('login'));
  $this->assertGuest();
 }
 public function test_role_middleware_menolak_staff_dari_area_admin():void {
  // [P09] Middleware alias role:admin menolak staff dengan 403.
  $u=User::factory()->create(); $u->forceFill(['role'=>'staff'])->save();
  $this->actingAs($u)->get('/admin-only')->assertForbidden();
 }
 public function test_registrasi_tidak_bisa_memilih_role_admin():void {
  // [P09] role dari request harus diabaikan.
  $this->post('/register',['name'=>'Peserta','email'=>'peserta@contoh.test','password'=>'Password123!','password_confirmation'=>'Password123!','role'=>'admin'])->assertRedirect(route('dashboard'));
  $this->assertDatabaseHas('users',['email'=>'peserta@contoh.test','role'=>'staff']);
 }
}
