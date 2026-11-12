@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<h1 class="page-heading mb-2">Dashboard Laravel SI</h1>
<p class="text-secondary">Selamat datang, {{ auth()->user()->name }}. Materi terintegrasi Pertemuan 1–12.</p>
<div class="row g-3 mb-4">
 @foreach([['label'=>'Mahasiswa','angka'=>$jumlahMahasiswa,'url'=>route('mahasiswa.index')],['label'=>'Program Studi','angka'=>$jumlahProdi,'url'=>route('program-studi.index')],['label'=>'Mata Kuliah','angka'=>$jumlahMataKuliah,'url'=>route('mata-kuliah.index')]] as $item)
 <div class="col-md-4"><div class="card h-100"><div class="card-body"><p class="text-secondary">{{ $item['label'] }}</p><h2 class="display-6">{{ $item['angka'] }}</h2><a href="{{ $item['url'] }}">Lihat data</a></div></div></div>
 @endforeach
</div>
{{-- [P09] Hanya admin melihat tautan area administrasi. Gate server tetap wajib. --}}
@can('admin-area')<div class="alert alert-info">Anda masuk sebagai <strong>admin</strong>: dapat mengelola data dan mengunggah dokumen.</div>
@else<div class="alert alert-secondary">Anda masuk sebagai <strong>staff</strong>: hanya dapat melihat data dan mengunduh PDF yang diizinkan.</div>@endcan
<div class="card"><div class="card-body"><h5>Profil akun (P06 one-to-one)</h5>
<p class="mb-1">Email: {{ auth()->user()->email }}</p><p>Telepon: {{ auth()->user()->profile?->telepon ?? 'Belum diisi' }}</p>
<a href="{{ route('external-posts.index') }}" class="btn btn-outline-primary">Praktikum P12: API Eksternal</a></div></div>
@endsection
