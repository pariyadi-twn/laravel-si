<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;
class PasswordResetController extends Controller {
 public function forgotForm(): View { return view('auth.forgot-password'); }
 public function sendLink(Request $request): RedirectResponse {
  $request->validate(['email'=>['required','email']]);
  // [P09] MAIL_MAILER=log: email latihan tertulis di storage/logs/laravel.log.
  Password::sendResetLink($request->only('email'));
  return back()->with('success','Jika email terdaftar, tautan reset akan dikirim. Periksa mail log pada mode latihan.');
 }
 public function resetForm(string $token,Request $request): View {
  return view('auth.reset-password',['token'=>$token,'email'=>$request->query('email','')]);
 }
 public function reset(Request $request): RedirectResponse {
  $data=$request->validate(['token'=>['required'],'email'=>['required','email'],'password'=>['required','confirmed',PasswordRule::min(8)->letters()->numbers()]]);
  $status=Password::reset($data,function(User $user,string $password):void {
   $user->forceFill(['password'=>Hash::make($password),'remember_token'=>Str::random(60)])->save();
   event(new PasswordReset($user));
  });
  return $status===Password::PASSWORD_RESET
   ? redirect()->route('login')->with('success','Password berhasil diperbarui.')
   : back()->withErrors(['email'=>__($status)]);
 }
}
