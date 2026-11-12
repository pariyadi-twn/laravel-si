<?php
// [P10] Foto berada di disk public, PDF di disk local privat.
return [
 'default' => env('FILESYSTEM_DISK', 'local'),
 'disks' => [
  'local' => ['driver' => 'local', 'root' => storage_path('app/private'), 'serve' => true, 'throw' => false],
  'public' => ['driver' => 'local', 'root' => storage_path('app/public'), 'url' => env('APP_URL').'/storage', 'visibility' => 'public', 'throw' => false],
 ],
 'links' => [public_path('storage') => storage_path('app/public')],
];
