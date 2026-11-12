@extends('layouts.app')
@section('title','Daftar Mahasiswa')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="page-heading">Daftar Mahasiswa</h1>
 @can('create',App\Models\Mahasiswa::class)<a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">+ Tambah Mahasiswa</a>@endcan
</div>
{{-- [P05] Filter pencarian dikirim lewat query string; pagination denganQueryString(). --}}
<form class="row g-2 mb-3" method="get" action="{{ route('mahasiswa.index') }}"><div class="col-md-8"><label class="form-label" for="q">Cari nama atau NIM</label><input class="form-control" name="q" id="q" value="{{ $keyword }}" placeholder="mis. 2026 / Rahma"></div><div class="col-md-4 d-flex align-items-end gap-2"><button class="btn btn-primary">Cari</button><a class="btn btn-outline-secondary" href="{{ route('mahasiswa.index') }}">Reset</a></div></form>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>NIM</th><th>Nama</th><th>Program Studi</th><th>MK diambil</th><th>Aksi</th></tr></thead><tbody>
@forelse($mahasiswas as $m)<tr><td>{{ $m->nim }}</td><td>{{ $m->nama }}</td><td>{{ $m->programStudi?->nama }}</td><td>{{ $m->mataKuliahs->count() }}</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('mahasiswa.show',$m) }}">Detail</a>
@can('update',$m)<a class="btn btn-sm btn-outline-secondary" href="{{ route('mahasiswa.edit',$m) }}">Edit</a>@endcan</td></tr>
@empty<tr><td colspan="5" class="text-center text-secondary">Belum ada data.</td></tr>@endforelse
</tbody></table></div></div>
<div class="mt-3">{{ $mahasiswas->links() }}</div>
@endsection
