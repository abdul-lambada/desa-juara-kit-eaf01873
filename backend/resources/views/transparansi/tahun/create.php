<?php
/** @var array $year */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tahun Anggaran</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Tahun Anggaran</label>
                        <input type="number" name="fiscal_year" class="form-control" value="<?= htmlspecialchars(session()->old('fiscal_year', $year['fiscal_year'] ?? date('Y'))) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars(session()->old('description', $year['description'] ?? '')) ?></textarea>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" <?= session()->old('is_published', $year['is_published'] ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_published">Publikasikan tahun ini</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transparansi/tahun" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
