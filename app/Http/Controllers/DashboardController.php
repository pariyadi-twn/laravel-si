<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use Illuminate\View\View;
class DashboardController extends Controller {
 public function index(): View {
  // [P02] Controller menyiapkan response Blade; [P06] aggregate hitung data.
  return view('dashboard.index',['jumlahMahasiswa'=>Mahasiswa::count(),'jumlahProdi'=>ProgramStudi::count(),'jumlahMataKuliah'=>MataKuliah::count()]);
 }
}
