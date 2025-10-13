<?php
/** @var array $album */
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Album</h6>
                <div>
                    <a href="/galeri/albums/<?= $album['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/galeri/albums/<?= $album['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus album ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($album['cover_image_url'])): ?>
                    <img src="<?= htmlspecialchars($album['cover_image_url']) ?>" class="img-fluid rounded mb-3" alt="Sampul Album">
                <?php endif; ?>

                <dl class="row mb-0">
                    <dt class="col-sm-4">Judul</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($album['title']) ?></dd>

                    <dt class="col-sm-4">Slug</dt>
                    <dd class="col-sm-8"><code><?= htmlspecialchars($album['slug'] ?? '-') ?></code></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($album['description'] ?? '-')) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Unggulan</dt>
                    <dd class="col-sm-8">
                        <?php if (!empty($album['is_featured'])): ?>
                            <span class="badge bg-primary">Unggulan</span>
                        <?php else: ?>
                            <span class="text-muted">Tidak</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-sm-4">Dipublikasikan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($album['published_at'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($album['created_at'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($album['updated_at'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <h6 class="font-weight-bold">Kelola Foto</h6>
                <p class="text-muted mb-3">Tambahkan atau ubah foto yang terdapat dalam album ini.</p>
                <a href="/galeri/albums/<?= $album['id'] ?>/photos" class="btn btn-primary">
                    <i class="fas fa-images mr-2"></i>Kelola Foto
                </a>
            </div>
        </div>
    </div>
</div>
