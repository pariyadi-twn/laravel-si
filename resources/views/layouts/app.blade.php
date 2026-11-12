<!doctype html>
<html lang="id">
<head>
 <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>@yield('title','Laravel SI') — Praktikum Web Lanjut</title>
 {{-- [P03] Vite menyertakan Bootstrap + CSS kustom. Jalankan npm install && npm run build. --}}
 @vite(['resources/css/app.css','resources/js/app.js'])
 @stack('styles')
</head>
<body>
 <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container main-container">
   <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Laravel SI</a>
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUtama" aria-controls="navbarUtama" aria-expanded="false" aria-label="Buka navigasi"><span class="navbar-toggler-icon"></span></button>
   <div class="collapse navbar-collapse" id="navbarUtama">
    @auth
    <div class="navbar-nav me-auto">
      <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
      <a class="nav-link" href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
      <a class="nav-link" href="{{ route('program-studi.index') }}">Program Studi</a>
      <a class="nav-link" href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a>
      <a class="nav-link" href="{{ route('external-posts.index') }}">API Eksternal</a>
      @can('admin-area')<a class="nav-link" href="{{ route('admin.index') }}">Area Admin</a>@endcan
    </div>
    <span class="navbar-text me-3 text-white">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
    {{-- [P09] Logout harus form POST dan [P07] dilindungi CSRF. --}}
    <form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-sm btn-light">Logout</button></form>
    @else
    <div class="navbar-nav ms-auto"><a class="nav-link" href="{{ route('login') }}">Login</a><a class="nav-link" href="{{ route('register') }}">Registrasi</a></div>
    @endauth
   </div>
  </div>
 </nav>
 <main class="container main-container py-4">
   {{-- [P07] Flash session menampilkan hasil create/update/delete; pesan validasi tidak hilang. --}}
   @if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>@endif
   @if(session('error'))<div class="alert alert-danger" role="alert">{{ session('error') }}</div>@endif
   @yield('content')
 </main>
 <footer class="container text-center text-secondary small py-3">Pemrograman Berbasis Web Lanjut • Prodi Sistem Informasi • Materi P01–P12</footer>
 @stack('scripts')
</body>
</html>
