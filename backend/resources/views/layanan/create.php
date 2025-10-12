<?php
/** @var array $layanan */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Layanan</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars(session()->old('nama', $layanan['nama'] ?? '')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5"><?= htmlspecialchars(session()->old('deskripsi', $layanan['deskripsi'] ?? '')) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Waktu Proses</label>
                            <input type="text" name="waktu_proses" class="form-control" value="<?= htmlspecialchars(session()->old('waktu_proses', $layanan['waktu_proses'] ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jam Layanan</label>
                            <input type="text" name="jam_layanan" class="form-control" value="<?= htmlspecialchars(session()->old('jam_layanan', $layanan['jam_layanan'] ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Biaya</label>
                            <input type="number" step="0.01" name="biaya" class="form-control" value="<?= htmlspecialchars(session()->old('biaya', $layanan['biaya'] ?? '')) ?>">
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Keterangan Biaya</label>
                        <textarea name="keterangan_biaya" class="form-control" rows="3"><?= htmlspecialchars(session()->old('keterangan_biaya', $layanan['keterangan_biaya'] ?? '')) ?></textarea>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="aktif" name="aktif" value="1" <?= session()->old('aktif', $layanan['aktif'] ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="aktif">Layanan Aktif</label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/layanan" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
