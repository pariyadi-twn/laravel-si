{{-- [P10] Foto publik non-sensitif, PDF privat hanya melalui endpoint terproteksi. --}}
<div class="card mb-3"><div class="card-body"><h5>Foto Mahasiswa</h5>
@if($mahasiswa->foto_path)<img class="img-fluid rounded" style="max-height:210px" alt="Foto contoh mahasiswa" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($mahasiswa->foto_path) }}">@else<p class="text-secondary">Belum ada foto.</p>@endif
@can('update',$mahasiswa)
<form method="post" action="{{ route('mahasiswa.foto.store',$mahasiswa) }}" enctype="multipart/form-data" class="mt-2">@csrf
<label class="form-label" for="foto">Unggah foto (JPG, PNG, WebP, maks. 2 MB)</label><input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/webp" class="form-control @error('foto') is-invalid @enderror">
@error('foto')<p class="text-danger small">{{ $message }}</p>@enderror<button class="btn btn-sm btn-primary mt-2">Unggah / Ganti</button></form>
@if($mahasiswa->foto_path)<form method="post" action="{{ route('mahasiswa.foto.destroy',$mahasiswa) }}" class="mt-2">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus Foto</button></form>@endif
@endcan</div></div>
<div class="card"><div class="card-body"><h5>Dokumen PDF Privat</h5><ul class="list-group mb-3">
@forelse($mahasiswa->dokumens as $d)<li class="list-group-item"><div class="fw-semibold">{{ $d->kategori }} — {{ $d->nama_asli }}</div>
<a href="{{ route('mahasiswa.dokumen.download',[$mahasiswa,$d]) }}" class="btn btn-sm btn-outline-primary mt-1">Unduh PDF</a>
@can('update',$mahasiswa)<form method="post" action="{{ route('mahasiswa.dokumen.destroy',[$mahasiswa,$d]) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger mt-1">Hapus</button></form>@endcan</li>
@empty<li class="list-group-item text-secondary">Belum ada PDF.</li>@endforelse</ul>
@can('update',$mahasiswa)
<form action="{{ route('mahasiswa.dokumen.store',$mahasiswa) }}" method="post" enctype="multipart/form-data">@csrf
<label class="form-label" for="kategori">Kategori</label><select id="kategori" name="kategori" class="form-select mb-2"><option>Surat</option><option>Sertifikat</option><option>Lainnya</option></select>
<label class="form-label" for="dokumen">PDF maks. 5 MB</label><input name="dokumen" id="dokumen" type="file" accept="application/pdf" class="form-control @error('dokumen') is-invalid @enderror">
@error('dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror<button class="btn btn-primary mt-2">Unggah Dokumen</button></form>
@endcan</div></div>
