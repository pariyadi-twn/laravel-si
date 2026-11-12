{-- [P03] Blade UI dan Bootstrap untuk aplikasi akademik. --}
@extends('layouts.app')
@section('title','Detail Program Studi')
@section('content')<h1>{{ $prodi->nama }} ({{ $prodi->kode }})</h1><div class="card"><div class="card-body"><h5>Mahasiswa</h5><ul>@forelse($prodi->mahasiswas as $m)<li><a href="{{ route('mahasiswa.show',$m) }}">{{ $m->nim }} — {{ $m->nama }}</a></li>@empty<li>Belum ada mahasiswa</li>@endforelse</ul>
@can('delete',$prodi)<form action="{{ route('program-studi.destroy',$prodi) }}" method="post">@csrf @method('DELETE')<button class="btn btn-outline-danger">Hapus Prodi (jika tidak digunakan)</button></form>@endcan</div></div>
@endsection
