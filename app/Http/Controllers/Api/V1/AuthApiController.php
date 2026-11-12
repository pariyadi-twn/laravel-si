<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
class AuthApiController extends Controller {
 public function login(Request $request):JsonResponse {
  // [P11] Login API memeriksa email+password, bukan cookie halaman web.
  $data=$request->validate(['email'=>['required','email'],'password'=>['required','string'],'device_name'=>['required','string','max:80']]);
  $user=User::where('email',$data['email'])->first();
  if(!$user || !Hash::check($data['password'],$user->password)) return response()->json(['message'=>'Kredensial tidak sesuai.'],401);
  $abilities=['prodi:read','mahasiswa:read'];
  if($user->isAdmin()) $abilities=array_merge($abilities,['prodi:write','mahasiswa:write']);
  // [P11] Token dengan kemampuan berbeda untuk admin vs staff, expire 1 hari.
  $token=$user->createToken($data['device_name'],$abilities,now()->addDay())->plainTextToken;
  return response()->json(['message'=>'Login berhasil.','token_type'=>'Bearer','access_token'=>$token,'user'=>['id'=>$user->id,'name'=>$user->name,'role'=>$user->role]]);
 }
 public function me(Request $request):JsonResponse { $u=$request->user();return response()->json(['data'=>['id'=>$u->id,'name'=>$u->name,'role'=>$u->role]]); }
 public function logout(Request $request):JsonResponse {
  $token=$request->user()->currentAccessToken();
  if($token instanceof PersonalAccessToken) $token->delete();
  // [P11] Token dicabut, request berikutnya harus 401.
  return response()->json(['message'=>'Token perangkat ini dicabut.']);
 }
}
