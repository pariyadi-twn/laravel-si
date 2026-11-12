<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreProgramStudiRequest;
use App\Http\Requests\UpdateProgramStudiRequest;
use App\Models\ProgramStudi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
class ProgramStudiController extends Controller {
 public function index(): View { Gate::authorize('viewAny',ProgramStudi::class); return view('program-studi.index',['prodis'=>ProgramStudi::withCount('mahasiswas')->orderBy('nama')->paginate(10)]); }
 public function create(): View { Gate::authorize('create',ProgramStudi::class); return view('program-studi.form',['prodi'=>new ProgramStudi(),'isEdit'=>false]); }
 public function store(StoreProgramStudiRequest $request): RedirectResponse { ProgramStudi::create($request->validated()); return redirect()->route('program-studi.index')->with('success','Program studi berhasil ditambahkan.'); }
 public function show(ProgramStudi $programStudi): View { Gate::authorize('view',$programStudi); return view('program-studi.show',['prodi'=>$programStudi->load('mahasiswas')]); }
 public function edit(ProgramStudi $programStudi): View { Gate::authorize('update',$programStudi); return view('program-studi.form',['prodi'=>$programStudi,'isEdit'=>true]); }
 public function update(UpdateProgramStudiRequest $request,ProgramStudi $programStudi): RedirectResponse { $programStudi->update($request->validated()); return redirect()->route('program-studi.index')->with('success','Program studi diperbarui.'); }
 public function destroy(ProgramStudi $programStudi): RedirectResponse {
  Gate::authorize('delete',$programStudi);
  // [P04] Foreign key restrict: jangan hapus prodi yang masih memiliki mahasiswa.
  if($programStudi->mahasiswas()->exists()) return back()->with('error','Program studi masih dipakai mahasiswa.');
  $programStudi->delete(); return redirect()->route('program-studi.index')->with('success','Program studi dihapus.');
 }
}
