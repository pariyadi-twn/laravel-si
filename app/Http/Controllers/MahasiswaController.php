<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
class MahasiswaController extends Controller {
 public function index(Request $request): View {
  Gate::authorize('viewAny',Mahasiswa::class); // [P09] Check server, bukan cuma sembunyikan tombol.
  // [P05] search, sorting, pagination. [P06] eager loading menghindari N+1.
  $keyword=trim((string)$request->query('q',''));
  $mahasiswas=Mahasiswa::query()
   ->with(['programStudi','mataKuliahs'])
   ->when($keyword!=='',fn($q)=>$q->where(function($sq)use($keyword){
      $sq->where('nama','like',"%{$keyword}%")->orWhere('nim','like',"%{$keyword}%");
   }))
   ->orderBy('nama')->paginate(10)->withQueryString();
  return view('mahasiswa.index',compact('mahasiswas','keyword'));
 }
 public function create(): View {
  Gate::authorize('create',Mahasiswa::class);
  return view('mahasiswa.form',['mahasiswa'=>new Mahasiswa(),'prodis'=>ProgramStudi::orderBy('nama')->get(),'mataKuliahs'=>MataKuliah::orderBy('nama')->get(),'isEdit'=>false]);
 }
 public function store(StoreMahasiswaRequest $request): RedirectResponse {
  // [P07] $request->validated() telah disaring Form Request, tidak menggunakan $request->all().
  $data=$request->validated(); $mataIds=$data['mata_kuliah_ids']??[];
  unset($data['mata_kuliah_ids'],$data['semester'],$data['tahun_akademik']);
  DB::transaction(function () use($data,$mataIds,$request):void {
   $m=Mahasiswa::create($data); // [P05] ORM create
   $m->mataKuliahs()->sync($this->pivotData($mataIds,$request->validated('semester'),$request->validated('tahun_akademik'))); // [P06] pivot
   Log::info('Mahasiswa dibuat',['mahasiswa_id'=>$m->id]); // [P07] Jangan log data sensitif.
  });
  return redirect()->route('mahasiswa.index')->with('success','Mahasiswa berhasil ditambahkan.'); // [P07] flash session
 }
 public function show(Mahasiswa $mahasiswa): View {
  Gate::authorize('view',$mahasiswa);
  // [P06] relasi dan agregat; [P10] metadata dokumen.
  $mahasiswa->load(['programStudi','mataKuliahs','dokumens'])->loadCount('mataKuliahs');
  return view('mahasiswa.show',compact('mahasiswa'));
 }
 public function edit(Mahasiswa $mahasiswa): View {
  Gate::authorize('update',$mahasiswa);
  $mahasiswa->load('mataKuliahs');
  return view('mahasiswa.form',['mahasiswa'=>$mahasiswa,'prodis'=>ProgramStudi::orderBy('nama')->get(),'mataKuliahs'=>MataKuliah::orderBy('nama')->get(),'isEdit'=>true]);
 }
 public function update(UpdateMahasiswaRequest $request,Mahasiswa $mahasiswa): RedirectResponse {
  $data=$request->validated(); $ids=$data['mata_kuliah_ids']??[];
  unset($data['mata_kuliah_ids'],$data['semester'],$data['tahun_akademik']);
  DB::transaction(function()use($mahasiswa,$data,$ids,$request):void {
   $mahasiswa->update($data); // [P05] CRUD update
   $mahasiswa->mataKuliahs()->sync($this->pivotData($ids,$request->validated('semester'),$request->validated('tahun_akademik'))); // [P06] update pivot
   Log::info('Mahasiswa diperbarui',['mahasiswa_id'=>$mahasiswa->id]); // [P07]
  });
  return redirect()->route('mahasiswa.show',$mahasiswa)->with('success','Data mahasiswa diperbarui.');
 }
 public function destroy(Mahasiswa $mahasiswa): RedirectResponse {
  Gate::authorize('delete',$mahasiswa);
  // [P10] Hapus file melalui filesystem ketika mahasiswa dihapus agar tidak yatim.
  $foto=$mahasiswa->foto_path;
  $dokumenPaths=$mahasiswa->dokumens()->get(['disk','path']);
  $id=$mahasiswa->id;
  $mahasiswa->delete(); // FK cascade membersihkan pivot dan metadata.
  if($foto){\Illuminate\Support\Facades\Storage::disk('public')->delete($foto);}
  foreach($dokumenPaths as $d){\Illuminate\Support\Facades\Storage::disk($d->disk)->delete($d->path);}
  Log::info('Mahasiswa dihapus',['mahasiswa_id'=>$id]);
  return redirect()->route('mahasiswa.index')->with('success','Data mahasiswa dihapus.');
 }
 private function pivotData(array $ids,string $semester,string $tahun):array {
  // [P06] Relasi many-to-many dengan atribut tambahan pivot.
  return collect($ids)->mapWithKeys(fn($id)=>[(int)$id=>['semester'=>$semester,'tahun_akademik'=>$tahun]])->all();
 }
}
