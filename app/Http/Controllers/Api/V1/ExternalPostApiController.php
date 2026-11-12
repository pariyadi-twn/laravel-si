<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Services\ExternalPostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class ExternalPostApiController extends Controller {
 public function index(Request $r,ExternalPostService $service):JsonResponse {
  // [P12] Endpoint internal yang meneruskan API eksternal dengan bentuk JSON konsisten.
  abort_unless($r->user()->tokenCan('mahasiswa:read') && in_array($r->user()->role,['admin','staff'],true),403);
  $input=$r->validate(['user_id'=>['nullable','integer','between:1,10']]);
  $result=$service->all(isset($input['user_id'])?(int)$input['user_id']:null);
  return response()->json($result['ok']?['data'=>$result['data']]:['message'=>$result['message']],$result['status']);
 }
 public function show(Request $r,int $id,ExternalPostService $service):JsonResponse {
  abort_unless($r->user()->tokenCan('mahasiswa:read') && in_array($r->user()->role,['admin','staff'],true),403);
  $result=$service->find($id);
  return response()->json($result['ok']?['data'=>$result['data']]:['message'=>$result['message']],$result['status']);
 }
}
