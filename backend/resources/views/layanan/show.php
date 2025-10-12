<?php
/** @var array $layanan */
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Layanan</h6>
                <div>
                    <a href="/layanan/<?= $layanan['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/layanan/<?= $layanan['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($layanan['nama']) ?></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($layanan['deskripsi'] ?? '-')) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Waktu Proses</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($layanan['waktu_proses'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Jam Layanan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($layanan['jam_layanan'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Biaya</dt>
                    <dd class="col-sm-8"><?= $layanan['biaya'] !== null ? 'Rp ' . number_format((float) $layanan['biaya'], 0, ',', '.') : '-' ?></dd>

                    <dt class="col-sm-4">Keterangan Biaya</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($layanan['keterangan_biaya'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= !empty($layanan['aktif']) ? 'success' : 'secondary' ?>">
                            <?= !empty($layanan['aktif']) ? 'Aktif' : 'Tidak Aktif' ?>
                        </span>
                    </dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($layanan['dibuat_pada'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($layanan['diperbarui_pada'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
