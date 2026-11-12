<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsureRole {
 public function handle(Request $request,Closure $next,string $role): Response {
  // [P09] Middleware otorisasi berbasis role setelah middleware auth.
  abort_unless($request->user() && $request->user()->role === $role, 403, 'Akses tidak diizinkan.');
  return $next($request);
 }
}
