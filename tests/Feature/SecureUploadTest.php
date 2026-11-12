<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class SecureUploadTest extends TestCase {
 use RefreshDatabase;
 public function test_staff_tidak_bisa_unggah_berkas():void {
  // [P10] Staff hanya read; role dicek Form Request/Policy server.
  $m=Mahasiswa::factory()->create(['program_studi_id'=>ProgramStudi::factory()->create()->id]);
  $u=User::factory()->create();$u->forceFill(['role'=>'staff'])->save();
  Storage::fake('local');
  $this->actingAs($u)->post(route('mahasiswa.dokumen.store',$m),['kategori'=>'Surat','dokumen'=>UploadedFile::fake()->create('uji.pdf',10,'application/pdf')])->assertForbidden();
 }
 public function test_pdf_dengan_ekstensi_exe_ditolak():void {
  $m=Mahasiswa::factory()->create(['program_studi_id'=>ProgramStudi::factory()->create()->id]);
  $u=User::factory()->create();$u->forceFill(['role'=>'admin'])->save();
  Storage::fake('local');
  $this->actingAs($u)->post(route('mahasiswa.dokumen.store',$m),['kategori'=>'Surat','dokumen'=>UploadedFile::fake()->create('virus.exe',8,'application/x-msdownload')])->assertSessionHasErrors('dokumen');
 }
}
