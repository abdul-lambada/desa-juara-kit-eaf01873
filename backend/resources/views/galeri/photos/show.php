<?php
/** @var array $album */
/** @var array $photo */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Foto</h6>
                <div>
                    <a href="/galeri/albums/<?= $album['id'] ?>/photos/<?= $photo['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/galeri/albums/<?= $album['id'] ?>/photos/<?= $photo['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body text-center">
                <img src="<?= htmlspecialchars($photo['image_url']) ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($photo['title']) ?>">
                <dl class="row">
                    <dt class="col-sm-4">Judul</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($photo['title']) ?></dd>

                    <dt class="col-sm-4">Urutan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars((string) $photo['display_order']) ?></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($photo['description'] ?? '-')) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($photo['created_at'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($photo['updated_at'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
