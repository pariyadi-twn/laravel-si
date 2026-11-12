<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;
class AuthController extends Controller {
 public function loginForm(): View { return view('auth.login'); }
 public function login(Request $request): RedirectResponse {
  // [P09] Validasi kredensial, autentikasi session, regenerasi ID session.
  $data=$request->validate(['email'=>['required','email'],'password'=>['required','string']]);
  if(!Auth::attempt($data, $request->boolean('remember'))) {
   return back()->withErrors(['email'=>'Email atau password tidak sesuai.'])->onlyInput('email');
  }
  $request->session()->regenerate();
  return redirect()->intended(route('dashboard'));
 }
 public function registerForm(): View { return view('auth.register'); }
 public function register(Request $request): RedirectResponse {
  $data=$request->validate(['name'=>['required','string','max:120'],'email'=>['required','email','max:255','unique:users,email'],'password'=>['required','confirmed',PasswordRule::min(8)->letters()->numbers()]]);
  // [P09] Registrasi SELALU mendapatkan staff. Role admin tidak dapat ditentukan dari request.
  $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>Hash::make($data['password'])]);
  Auth::login($user);
  $request->session()->regenerate();
  return redirect()->route('dashboard')->with('success','Akun staff berhasil dibuat.');
 }
 public function logout(Request $request): RedirectResponse {
  // [P09] Logout harus POST + CSRF token (lihat resources/views/layouts/app.blade.php).
  Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
  return redirect()->route('login')->with('success','Anda berhasil logout.');
 }
}
