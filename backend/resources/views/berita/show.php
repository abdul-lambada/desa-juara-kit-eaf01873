<?php
/** @var array $berita */
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Berita</h6>
                <div>
                    <a href="/berita/<?= $berita['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/berita/<?= $berita['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($berita['gambar_sampul'])): ?>
                    <img src="<?= htmlspecialchars($berita['gambar_sampul']) ?>" class="img-fluid rounded mb-3" alt="Gambar Sampul">
                <?php endif; ?>

                <dl class="row mb-0">
                    <dt class="col-sm-4">Judul</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($berita['judul']) ?></dd>

                    <dt class="col-sm-4">Ringkasan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($berita['ringkasan'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Isi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($berita['isi'])) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Penulis</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($berita['nama_penulis'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= $berita['status'] === 'diterbitkan' ? 'success' : ($berita['status'] === 'draf' ? 'secondary' : 'warning') ?>">
                            <?= htmlspecialchars(ucfirst($berita['status'])) ?>
                        </span>
                    </dd>

                    <dt class="col-sm-4">Unggulan</dt>
                    <dd class="col-sm-8">
                        <?= !empty($berita['unggulan']) ? '<span class="badge bg-primary">Ya</span>' : '<span class="text-muted">Tidak</span>' ?>
                    </dd>

                    <dt class="col-sm-4">Dipublikasikan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($berita['dipublikasikan_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($berita['dibuat_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($berita['diperbarui_pada'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
