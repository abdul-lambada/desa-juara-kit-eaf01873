<?php

use App\Controllers\AuthController;
use App\Controllers\BeritaController;
use App\Controllers\HomeController;
use App\Controllers\LayananController;
use App\Controllers\KategoriBeritaController;
use App\Controllers\KategoriUmkmController;
use App\Controllers\PengumumanController;
use App\Controllers\PenggunaController;
use App\Controllers\GalleryAlbumController;
use App\Controllers\GalleryPhotoController;
use App\Controllers\TransparencyYearController;
use App\Controllers\StatisticsSnapshotController;

$router->get('/', [HomeController::class, 'index']);

$router->get('auth/login', [AuthController::class, 'login']);
$router->post('auth/process', [AuthController::class, 'process']);
$router->get('auth/logout', [AuthController::class, 'logout']);

$router->resource('pengguna', PenggunaController::class);
$router->resource('kategori-berita', KategoriBeritaController::class);
$router->resource('kategori-umkm', KategoriUmkmController::class);
$router->resource('berita', BeritaController::class);
$router->resource('pengumuman', PengumumanController::class);
$router->resource('layanan', LayananController::class);
$router->resource('galeri/albums', GalleryAlbumController::class);

$router->get('galeri/albums/{album}/photos', [GalleryPhotoController::class, 'index']);
$router->get('galeri/albums/{album}/photos/create', [GalleryPhotoController::class, 'create']);
$router->post('galeri/albums/{album}/photos', [GalleryPhotoController::class, 'store']);
$router->get('galeri/albums/{album}/photos/{id}/edit', [GalleryPhotoController::class, 'edit']);
$router->put('galeri/albums/{album}/photos/{id}', [GalleryPhotoController::class, 'update']);
$router->delete('galeri/albums/{album}/photos/{id}', [GalleryPhotoController::class, 'destroy']);

$router->resource('statistik', StatisticsSnapshotController::class);
$router->post('statistik/{id}/age-groups', [StatisticsSnapshotController::class, 'storeAgeGroup']);
$router->put('statistik/{id}/age-groups/{group}', [StatisticsSnapshotController::class, 'updateAgeGroup']);
$router->delete('statistik/{id}/age-groups/{group}', [StatisticsSnapshotController::class, 'destroyAgeGroup']);

$router->post('statistik/{id}/educations', [StatisticsSnapshotController::class, 'storeEducation']);
$router->put('statistik/{id}/educations/{education}', [StatisticsSnapshotController::class, 'updateEducation']);
$router->delete('statistik/{id}/educations/{education}', [StatisticsSnapshotController::class, 'destroyEducation']);

$router->post('statistik/{id}/occupations', [StatisticsSnapshotController::class, 'storeOccupation']);
$router->put('statistik/{id}/occupations/{occupation}', [StatisticsSnapshotController::class, 'updateOccupation']);
$router->delete('statistik/{id}/occupations/{occupation}', [StatisticsSnapshotController::class, 'destroyOccupation']);

$router->resource('transparansi/tahun', TransparencyYearController::class);
