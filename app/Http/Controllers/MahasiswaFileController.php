<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMahasiswaDokumenRequest;
use App\Http\Requests\StoreMahasiswaFotoRequest;
use App\Models\Mahasiswa;
use App\Models\MahasiswaDokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;
use Symfony\Component\HttpFoundation\StreamedResponse;
class MahasiswaFileController extends Controller {
 public function storeFoto(StoreMahasiswaFotoRequest $request,Mahasiswa $mahasiswa): RedirectResponse {
  // [P10] Form Request memastikan MIME dan ukuran. Folder/nama file dibuat server.
  $path=$request->file('foto')->store('mahasiswa/foto/'.$mahasiswa->id,'public');
  if(!is_string($path)){throw new RuntimeException('Foto gagal disimpan.');}
  $lama=$mahasiswa->foto_path;
  try { $mahasiswa->foto_path=$path; $mahasiswa->save(); }
  catch(Throwable $e){Storage::disk('public')->delete($path); throw $e;}
  if($lama){Storage::disk('public')->delete($lama);}
  Log::info('Foto mahasiswa diperbarui',['mahasiswa_id'=>$mahasiswa->id]);
  return back()->with('success','Foto mahasiswa diperbarui.');
 }
 public function destroyFoto(Mahasiswa $mahasiswa): RedirectResponse {
  Gate::authorize('update',$mahasiswa); // [P09] admin-only.
  $lama=$mahasiswa->foto_path; $mahasiswa->foto_path=null; $mahasiswa->save();
  if($lama){Storage::disk('public')->delete($lama);}
  return back()->with('success','Foto berhasil dihapus.');
 }
 public function storeDokumen(StoreMahasiswaDokumenRequest $request,Mahasiswa $mahasiswa): RedirectResponse {
  // [P10] File PDF tidak diberi public URL. Disimpan relatif ke storage/app/private.
  $file=$request->file('dokumen'); $path=$file->store('mahasiswa/dokumen/'.$mahasiswa->id,'local');
  if(!is_string($path)){throw new RuntimeException('Dokumen gagal disimpan.');}
  try {
   $mahasiswa->dokumens()->create([
    'uploaded_by'=>$request->user()->id,
    'kategori'=>$request->validated('kategori'),
    'nama_asli'=>mb_substr($file->getClientOriginalName(),0,255),
    'disk'=>'local','path'=>$path,'mime_type'=>'application/pdf','ukuran'=>$file->getSize(),
   ]);
  } catch(Throwable $e){Storage::disk('local')->delete($path);throw $e;}
  Log::info('Dokumen privat ditambahkan',['mahasiswa_id'=>$mahasiswa->id]);
  return back()->with('success','Dokumen PDF berhasil diunggah secara privat.');
 }
 public function downloadDokumen(Mahasiswa $mahasiswa,MahasiswaDokumen $dokumen): StreamedResponse {
  // [P10] Uji kepemilikan relasi dan Policy sebelum memberikan file (hindari IDOR).
  Gate::authorize('view',$mahasiswa);
  abort_unless($dokumen->mahasiswa_id===$mahasiswa->id,404);
  abort_unless($dokumen->disk==='local' && Storage::disk('local')->exists($dokumen->path),404);
  return Storage::disk('local')->download($dokumen->path,'dokumen-mahasiswa-'.$dokumen->id.'.pdf',['Content-Type'=>'application/octet-stream','X-Content-Type-Options'=>'nosniff']);
 }
 public function destroyDokumen(Mahasiswa $mahasiswa,MahasiswaDokumen $dokumen): RedirectResponse {
  Gate::authorize('update',$mahasiswa);
  abort_unless($dokumen->mahasiswa_id===$mahasiswa->id,404);
  $path=$dokumen->path; $dokumen->delete();
  if(!Storage::disk('local')->delete($path)) { Log::warning('Dokumen yatim perlu dibersihkan',['dokumen_id'=>$dokumen->id]); }
  return back()->with('success','Dokumen dihapus.');
 }
}
