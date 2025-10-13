<?php
/** @var array $year */
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Tahun Anggaran</h6>
                <div>
                    <a href="/transparansi/tahun/<?= $year['id'] ?>/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                    <form action="/transparansi/tahun/<?= $year['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Tahun Anggaran</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($year['fiscal_year']) ?></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($year['description'] ?? '-')) ?>
                        </div>
                    </dd>

                    <dt class="col-sm-4">Status Publikasi</dt>
                    <dd class="col-sm-8">
                        <?php if (!empty($year['is_published'])): ?>
                            <span class="badge bg-success">Dipublikasikan</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Draft</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-sm-4">Dibuat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($year['created_at'] ?? '-') ?></dd>

                    <dt class="col-sm-4">Diperbarui</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($year['updated_at'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <h6 class="font-weight-bold">Langkah Berikutnya</h6>
                <p class="text-muted mb-3">Kelola pendapatan, belanja, program, dan laporan untuk tahun ini.</p>
                <a href="#" class="btn btn-outline-primary disabled">Integrasi modul lain segera tersedia</a>
            </div>
        </div>
    </div>
</div>
