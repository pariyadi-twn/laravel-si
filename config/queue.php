<?php
// [P01] Konfigurasi lingkungan aplikasi.
return [
 'default' => env('QUEUE_CONNECTION', 'sync'),
 'connections' => ['sync' => ['driver' => 'sync']],
 'failed' => ['driver' => 'null'],
];
