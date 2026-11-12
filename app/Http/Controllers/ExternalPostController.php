<?php
namespace App\Http\Controllers;
use App\Services\ExternalPostService;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ExternalPostController extends Controller {
 public function index(Request $r,ExternalPostService $service):View {
  // [P12] Laravel HTTP Client -> Service -> Controller -> Blade. Bukan data DB lokal.
  $d=$r->validate(['user_id'=>['nullable','integer','between:1,10']]);
  $userId=isset($d['user_id'])?(int)$d['user_id']:null;
  $result=$service->all($userId);
  return view('external-posts.index',['posts'=>$result['ok']?$result['data']:[],'error'=>$result['ok']?null:$result['message'],'userId'=>$userId]);
 }
 public function show(int $id,ExternalPostService $service):View {
  $result=$service->find($id);
  if($result['status']===404)abort(404);
  return view('external-posts.show',['post'=>$result['ok']?$result['data']:null,'error'=>$result['ok']?null:$result['message']]);
 }
}
