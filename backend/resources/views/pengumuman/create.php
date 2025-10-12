<?php
/** @var array $pengumuman */
/** @var array $statusOptions */
/** @var array $prioritasOptions */
/** @var string $formAction */
/** @var string $formMethod */
/** @var string $submitLabel */
?>
<div class="row">
    <div class="col-lg-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Pengumuman</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (in_array($formMethod, ['PUT', 'PATCH', 'DELETE'], true)): ?>
                        <input type="hidden" name="_method" value="<?= $formMethod ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars(session()->old('judul', $pengumuman['judul'] ?? '')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Pengumuman</label>
                        <textarea name="isi" class="form-control" rows="6" required><?= htmlspecialchars(session()->old('isi', $pengumuman['isi'] ?? '')) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Prioritas</label>
                            <select name="prioritas" class="form-select" required>
                                <?php foreach ($prioritasOptions as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= (session()->old('prioritas', $pengumuman['prioritas'] ?? 'sedang') === $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <?php foreach ($statusOptions as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= (session()->old('status', $pengumuman['status'] ?? 'dijadwalkan') === $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars(session()->old('lokasi', $pengumuman['lokasi'] ?? '')) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Kontak Nama</label>
                            <input type="text" name="kontak_nama" class="form-control" value="<?= htmlspecialchars(session()->old('kontak_nama', $pengumuman['kontak_nama'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kontak Telepon</label>
                            <input type="text" name="kontak_telepon" class="form-control" value="<?= htmlspecialchars(session()->old('kontak_telepon', $pengumuman['kontak_telepon'] ?? '')) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Publikasi</label>
                            <input type="datetime-local" name="dipublikasikan_pada" class="form-control" value="<?= htmlspecialchars(str_replace(' ', 'T', session()->old('dipublikasikan_pada', $pengumuman['dipublikasikan_pada'] ?? ''))) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Berakhir</label>
                            <input type="datetime-local" name="berakhir_pada" class="form-control" value="<?= htmlspecialchars(str_replace(' ', 'T', session()->old('berakhir_pada', $pengumuman['berakhir_pada'] ?? ''))) ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/pengumuman" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
