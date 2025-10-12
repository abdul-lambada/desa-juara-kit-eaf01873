<?php
/** @var array $pengguna */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pengguna</h6>
                <div>
                    <a href="/pengguna/<?= $pengguna['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/pengguna/<?= $pengguna['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="<?= htmlspecialchars($pengguna['foto_profil'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($pengguna['nama'])) ?>" class="rounded-circle" width="120" alt="Foto Profil">
                </div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengguna['nama']) ?></dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengguna['email']) ?></dd>

                    <dt class="col-sm-4">Telepon</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengguna['telepon'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= $pengguna['status'] === 'aktif' ? 'success' : ($pengguna['status'] === 'diblokir' ? 'danger' : 'secondary') ?>">
                            <?= htmlspecialchars(ucfirst($pengguna['status'])) ?>
                        </span>
                    </dd>

                    <dt class="col-sm-4">Terdaftar</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengguna['dibuat_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Terakhir Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengguna['diperbarui_pada'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
