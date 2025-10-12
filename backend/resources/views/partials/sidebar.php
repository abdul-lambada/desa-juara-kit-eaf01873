<?php
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

$menu = [
    'utama' => [
        [
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'label' => 'Dasbor',
            'url' => '/',
            'active' => $requestUri === '/',
        ],
    ],
    'konten' => [
        [
            'icon' => 'fas fa-fw fa-users',
            'label' => 'Pengguna',
            'url' => '/pengguna',
            'active' => str_starts_with($requestUri, '/pengguna'),
        ],
        [
            'icon' => 'fas fa-fw fa-newspaper',
            'label' => 'Berita',
            'url' => '/berita',
            'active' => str_starts_with($requestUri, '/berita'),
        ],
        [
            'icon' => 'fas fa-fw fa-bullhorn',
            'label' => 'Pengumuman',
            'url' => '/pengumuman',
            'active' => str_starts_with($requestUri, '/pengumuman'),
        ],
        [
            'icon' => 'fas fa-fw fa-hand-holding-heart',
            'label' => 'Layanan',
            'url' => '/layanan',
            'active' => str_starts_with($requestUri, '/layanan'),
        ],
    ],
];
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Desa Juara</div>
    </a>

    <hr class="sidebar-divider my-0">

    <?php foreach ($menu['utama'] as $item): ?>
        <li class="nav-item <?= $item['active'] ? 'active' : '' ?>">
            <a class="nav-link" href="<?= htmlspecialchars($item['url']) ?>">
                <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                <span><?= htmlspecialchars($item['label']) ?></span>
            </a>
        </li>
    <?php endforeach; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Konten Desa
    </div>

    <?php foreach ($menu['konten'] as $item): ?>
        <li class="nav-item <?= $item['active'] ? 'active' : '' ?>">
            <a class="nav-link" href="<?= htmlspecialchars($item['url']) ?>">
                <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                <span><?= htmlspecialchars($item['label']) ?></span>
            </a>
        </li>
    <?php endforeach; ?>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="/sb-admin-2/img/undraw_rocket.svg" alt="">
        <p class="text-center mb-2">Kelola data desa secara digital untuk pelayanan publik yang lebih baik.</p>
        <a class="btn btn-success btn-sm" href="/" target="_blank">Lihat Situs Desa</a>
    </div>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
