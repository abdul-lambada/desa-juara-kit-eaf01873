<?php
/** @var array $album */
/** @var array $photo */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Foto Album</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Judul Foto</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars(session()->old('title', $photo['title'] ?? '')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars(session()->old('description', $photo['description'] ?? '')) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">URL Foto</label>
                            <input type="text" name="image_url" class="form-control" value="<?= htmlspecialchars(session()->old('image_url', $photo['image_url'] ?? '')) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutan Tampilan</label>
                            <input type="number" name="display_order" min="1" class="form-control" value="<?= htmlspecialchars(session()->old('display_order', $photo['display_order'] ?? 1)) ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/galeri/albums/<?= $album['id'] ?>/photos" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <h6 class="font-weight-bold">Preview</h6>
                <p class="text-muted mb-3">Tempelkan URL foto valid untuk melihat preview setelah disimpan.</p>
                <?php $previewUrl = session()->old('image_url', $photo['image_url'] ?? ''); ?>
                <?php if ($previewUrl): ?>
                    <img src="<?= htmlspecialchars($previewUrl) ?>" class="img-fluid rounded" alt="Preview Foto">
                <?php else: ?>
                    <div class="text-muted">Preview akan muncul setelah URL foto diisi.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
