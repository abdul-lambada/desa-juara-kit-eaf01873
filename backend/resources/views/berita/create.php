<?php
/** @var array $berita */
/** @var array $kategoriOptions */
/** @var array $statusOptions */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Berita</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars(session()->old('judul', $berita['judul'] ?? '')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategoriOptions as $id => $nama): ?>
                                <option value="<?= $id ?>" <?= (session()->old('kategori_id', $berita['kategori_id'] ?? '') == $id) ? 'selected' : '' ?>><?= htmlspecialchars($nama) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="ringkasan" class="form-control" rows="3"><?= htmlspecialchars(session()->old('ringkasan', $berita['ringkasan'] ?? '')) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea name="isi" class="form-control" rows="8" required><?= htmlspecialchars(session()->old('isi', $berita['isi'] ?? '')) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Gambar Sampul (URL)</label>
                            <input type="text" name="gambar_sampul" class="form-control" value="<?= htmlspecialchars(session()->old('gambar_sampul', $berita['gambar_sampul'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Penulis</label>
                            <input type="text" name="nama_penulis" class="form-control" value="<?= htmlspecialchars(session()->old('nama_penulis', $berita['nama_penulis'] ?? '')) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <?php foreach ($statusOptions as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= (session()->old('status', $berita['status'] ?? 'draf') === $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jadwal Publikasi</label>
                            <input type="datetime-local" name="dipublikasikan_pada" class="form-control" value="<?= htmlspecialchars(str_replace(' ', 'T', session()->old('dipublikasikan_pada', $berita['dipublikasikan_pada'] ?? ''))) ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="unggulan" name="unggulan" <?= session()->old('unggulan', $berita['unggulan'] ?? 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="unggulan">
                                    Tandai sebagai unggulan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/berita" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
