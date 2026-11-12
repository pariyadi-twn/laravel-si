<?php
// [P09] Web menggunakan cookie-session; [P11] API menggunakan Bearer token Sanctum.
return [
    'defaults' => ['guard' => env('AUTH_GUARD', 'web'), 'passwords' => 'users'],
    'guards' => ['web' => ['driver' => 'session', 'provider' => 'users']],
    'providers' => ['users' => ['driver' => 'eloquent', 'model' => App\Models\User::class]],
    'passwords' => ['users' => ['provider' => 'users', 'table' => 'password_reset_tokens', 'expire' => 60, 'throttle' => 60]],
    'password_timeout' => 10800,
];
