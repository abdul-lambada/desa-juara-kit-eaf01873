<?php

use App\Controllers\BeritaController;
use App\Controllers\HomeController;
use App\Controllers\LayananController;
use App\Controllers\PengumumanController;
use App\Controllers\PenggunaController;

$router->get('/', [HomeController::class, 'index']);

$router->resource('pengguna', PenggunaController::class);
$router->resource('berita', BeritaController::class);
$router->resource('pengumuman', PengumumanController::class);
$router->resource('layanan', LayananController::class);
