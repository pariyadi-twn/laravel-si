{-- [P03] Blade UI dan Bootstrap untuk aplikasi akademik. --}
@extends('layouts.app')
@section('title','Detail Mata Kuliah')
@section('content')<h1>{{ $mataKuliah->nama }}</h1><p>Kode: {{ $mataKuliah->kode }} • SKS: {{ $mataKuliah->sks }}</p>
<div class="card"><div class="card-body"><h5>Mahasiswa Mengambil Mata Kuliah</h5><ul>@forelse($mataKuliah->mahasiswas as $m)<li>{{ $m->nim }} — {{ $m->nama }} ({{ $m->pivot->semester }} {{ $m->pivot->tahun_akademik }})</li>@empty<li>Belum ada mahasiswa.</li>@endforelse</ul>
@can('delete',$mataKuliah)<form method="post" action="{{ route('mata-kuliah.destroy',$mataKuliah) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger">Hapus MK</button></form>@endcan</div></div>
@endsection
