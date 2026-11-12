{-- [P03] Blade UI dan Bootstrap untuk aplikasi akademik. --}
@extends('layouts.app')
@section('title','Program Studi')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="page-heading">Program Studi</h1>@can('create',App\Models\ProgramStudi::class)<a class="btn btn-primary" href="{{ route('program-studi.create') }}">+ Tambah Prodi</a>@endcan</div>
<div class="card"><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Kode</th><th>Nama</th><th>Jumlah Mahasiswa</th><th>Menu</th></tr></thead><tbody>
@forelse($prodis as $p)<tr><td>{{ $p->kode }}</td><td>{{ $p->nama }}</td><td>{{ $p->mahasiswas_count }}</td><td><a href="{{ route('program-studi.show',$p) }}">Lihat</a> @can('update',$p) | <a href="{{ route('program-studi.edit',$p) }}">Edit</a>@endcan</td></tr>
@empty<tr><td colspan="4">Belum ada program studi.</td></tr>@endforelse</tbody></table></div></div><div class="mt-3">{{ $prodis->links() }}</div>
@endsection
