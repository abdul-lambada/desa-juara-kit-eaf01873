<?php
/** @var array $pengumuman */
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pengumuman</h6>
                <div>
                    <a href="/pengumuman/<?= $pengumuman['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/pengumuman/<?= $pengumuman['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Judul</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengumuman['judul']) ?></dd>

                    <dt class="col-sm-4">Isi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($pengumuman['isi'])) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Prioritas</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= $pengumuman['prioritas'] === 'tinggi' ? 'danger' : ($pengumuman['prioritas'] === 'rendah' ? 'secondary' : 'info') ?>">
                            <?= htmlspecialchars(ucfirst($pengumuman['prioritas'])) ?>
                        </span>
                    </dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= $pengumuman['status'] === 'diterbitkan' ? 'success' : ($pengumuman['status'] === 'draf' ? 'secondary' : 'warning') ?>">
                            <?= htmlspecialchars(ucfirst($pengumuman['status'])) ?>
                        </span>
                    </dd>

                    <dt class="col-sm-4">Dipublikasikan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengumuman['dipublikasikan_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Berakhir</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengumuman['berakhir_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Lokasi</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengumuman['lokasi'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Kontak</dt>
                    <dd class="col-sm-8">
                        <?= htmlspecialchars($pengumuman['kontak_nama'] ?? '-') ?><br>
                        <span class="text-muted"><?= htmlspecialchars($pengumuman['kontak_telepon'] ?? '-') ?></span>
                    </dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengumuman['dibuat_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($pengumuman['diperbarui_pada'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
