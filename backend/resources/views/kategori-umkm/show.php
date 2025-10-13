<?php
/** @var array $kategori */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Kategori UMKM</h6>
                <div>
                    <a href="/kategori-umkm/<?= $kategori['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/kategori-umkm/<?= $kategori['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($kategori['nama']) ?></dd>

                    <dt class="col-sm-4">Slug</dt>
                    <dd class="col-sm-8"><code><?= htmlspecialchars($kategori['slug'] ?? '-') ?></code></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($kategori['deskripsi'] ?? '-')) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($kategori['dibuat_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($kategori['diperbarui_pada'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
