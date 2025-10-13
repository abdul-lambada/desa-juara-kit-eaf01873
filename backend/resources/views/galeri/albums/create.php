<?php
/** @var array $album */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Album Galeri</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Judul Album</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars(session()->old('title', $album['title'] ?? '')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars(session()->old('description', $album['description'] ?? '')) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Gambar Sampul (URL)</label>
                            <input type="text" name="cover_image_url" class="form-control" value="<?= htmlspecialchars(session()->old('cover_image_url', $album['cover_image_url'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Publikasi</label>
                            <input type="datetime-local" name="published_at" class="form-control" value="<?= htmlspecialchars(str_replace(' ', 'T', session()->old('published_at', $album['published_at'] ?? ''))) ?>">
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" <?= session()->old('is_featured', $album['is_featured'] ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_featured">Tandai sebagai album unggulan</label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/galeri/albums" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
