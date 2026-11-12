<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
class ExternalPostTest extends TestCase {
 use RefreshDatabase;
 public function test_artikel_eksternal_berhasil_tampil_dengan_http_fake():void {
  // [P12] Tidak ada koneksi ke internet sungguhan saat tes.
  Http::preventStrayRequests();
  Http::fake(['jsonplaceholder.typicode.com/*'=>Http::response([['userId'=>1,'id'=>1,'title'=>'Belajar Laravel','body'=>'Isi demo']],200)]);
  $user=User::factory()->create();
  $this->actingAs($user)->get('/referensi-posts')->assertOk()->assertSee('Belajar Laravel');
 }
 public function test_upstream_error_503_memberi_pesan_ramah():void {
  Http::preventStrayRequests();
  Http::fake(['jsonplaceholder.typicode.com/*'=>Http::response(['message'=>'down'],503)]);
  $user=User::factory()->create();
  $this->actingAs($user)->get('/referensi-posts')->assertOk()->assertSee('Layanan referensi belum tersedia');
 }
 public function test_api_eksternal_untuk_guest_401():void {
  $this->getJson('/api/v1/referensi-posts')->assertUnauthorized();
 }
}
