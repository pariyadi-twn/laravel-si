@extends('layouts.app')
@section('title','Detail Mahasiswa')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="page-heading">Detail Mahasiswa</h1><a class="btn btn-outline-secondary" href="{{ route('mahasiswa.index') }}">Kembali</a></div>
<div class="row g-3"><div class="col-lg-7"><div class="card"><div class="card-body">
 <h4>{{ $mahasiswa->nama }}</h4><p><strong>NIM:</strong> {{ $mahasiswa->nim }}<br><strong>Prodi:</strong> {{ $mahasiswa->programStudi?->nama }}<br><strong>Email:</strong> {{ $mahasiswa->email ?? '—' }}</p>
 <h5>Mata Kuliah Diambil ({{ $mahasiswa->mata_kuliahs_count }})</h5>
 {{-- [P06] Pivot berisi semester dan tahun akademik. --}}
 <ul class="list-group">@forelse($mahasiswa->mataKuliahs as $mk)<li class="list-group-item d-flex justify-content-between">{{ $mk->nama }}<span class="badge text-bg-secondary">{{ $mk->pivot->semester }} {{ $mk->pivot->tahun_akademik }}</span></li>@empty<li class="list-group-item">Belum ada mata kuliah.</li>@endforelse</ul>
 @can('update',$mahasiswa)<div class="mt-3"><a class="btn btn-outline-primary" href="{{ route('mahasiswa.edit',$mahasiswa) }}">Edit Mahasiswa</a>
 <form action="{{ route('mahasiswa.destroy',$mahasiswa) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data mahasiswa?')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Hapus</button></form></div>@endcan
 </div></div></div><div class="col-lg-5">@include('mahasiswa.partials.files')</div></div>
@endsection
