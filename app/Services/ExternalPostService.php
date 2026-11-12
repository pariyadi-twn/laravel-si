<?php
namespace App\Services;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ExternalPostService {
 private function baseUrl():string { return rtrim((string)config('services.external_posts.base_url'),'/'); }
 public function all(?int $userId=null):array {
  $query=['_limit'=>12];if($userId!==null)$query['userId']=$userId;
  $result=$this->send('/posts',$query);
  if(!$result['ok'])return $result;
  $posts=$result['data'];
  if(!is_array($posts)||!array_is_list($posts)) return $this->unavailable();
  // [P12] Jangan percaya struktur API eksternal; filter payload minimal.
  $posts=array_values(array_filter($posts,fn($p)=>is_array($p)&&isset($p['id'],$p['userId'],$p['title'],$p['body'])));
  return ['ok'=>true,'data'=>$posts,'message'=>null,'status'=>200];
 }
 public function find(int $id):array {
  $result=$this->send('/posts/'.$id);
  if(!$result['ok'])return $result;
  $p=$result['data'];
  if(!is_array($p)||!isset($p['id'],$p['title'],$p['body']))return $this->unavailable();
  return ['ok'=>true,'data'=>$p,'message'=>null,'status'=>200];
 }
 private function send(string $path,array $query=[]):array {
  try {
   // [P12] HTTP Client outbound: header, query, timeout, retry(2x), status check.
   $response=Http::acceptJson()->connectTimeout(3)->timeout(5)
    ->retry(2,250,throw:false)->get($this->baseUrl().$path,$query);
   if($response->status()===404)return ['ok'=>false,'data'=>null,'message'=>'Referensi tidak ditemukan.','status'=>404];
   if($response->failed()){
    Log::warning('Layanan eksternal gagal',['path'=>$path,'status'=>$response->status()]);
    return $this->unavailable();
   }
   return ['ok'=>true,'data'=>$response->json(),'message'=>null,'status'=>$response->status()];
  }catch(ConnectionException $e){
   Log::warning('API eksternal putus koneksi',['path'=>$path,'exception'=>get_class($e)]);
   return $this->unavailable();
  }
 }
 private function unavailable():array {return ['ok'=>false,'data'=>null,'message'=>'Layanan referensi belum tersedia. Silakan coba nanti.','status'=>503];}
}
