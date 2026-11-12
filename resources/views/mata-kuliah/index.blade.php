{-- [P03] Blade UI dan Bootstrap untuk aplikasi akademik. --}
@extends('layouts.app')
@section('title','Mata Kuliah')
@section('content')<div class="d-flex justify-content-between mb-3"><h1>Mata Kuliah</h1>@can('create',App\Models\MataKuliah::class)<a class="btn btn-primary" href="{{ route('mata-kuliah.create') }}">+ Tambah MK</a>@endcan</div>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Peserta</th><th>Aksi</th></tr></thead><tbody>@foreach($matakuliahs as $mk)<tr><td>{{ $mk->kode }}</td><td>{{ $mk->nama }}</td><td>{{ $mk->sks }}</td><td>{{ $mk->mahasiswas_count }}</td><td><a href="{{ route('mata-kuliah.show',$mk) }}">Detail</a>@can('update',$mk) | <a href="{{ route('mata-kuliah.edit',$mk) }}">Edit</a>@endcan</td></tr>@endforeach</tbody></table></div></div><div class="mt-3">{{ $matakuliahs->links() }}</div>
@endsection
