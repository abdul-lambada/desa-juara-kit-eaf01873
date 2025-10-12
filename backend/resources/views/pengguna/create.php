<?php
/** @var array $pengguna */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Pengguna</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars(session()->old('nama', $pengguna['nama'] ?? '')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars(session()->old('email', $pengguna['email'] ?? '')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars(session()->old('telepon', $pengguna['telepon'] ?? '')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <?php foreach (['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif', 'diblokir' => 'Diblokir'] as $value => $label): ?>
                                <option value="<?= $value ?>" <?= session()->old('status', $pengguna['status'] ?? 'aktif') === $value ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Profil (URL)</label>
                        <input type="text" name="foto_profil" class="form-control" value="<?= htmlspecialchars(session()->old('foto_profil', $pengguna['foto_profil'] ?? '')) ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pengguna" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
