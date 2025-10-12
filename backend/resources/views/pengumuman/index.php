<?php
/** @var array $pagination */
/** @var array $filters */
/** @var array $statusOptions */
/** @var array $prioritasOptions */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengumuman</h6>
        <a href="/pengumuman/create" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengumuman
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-sm-4">
                <input type="text" name="q" class="form-control" placeholder="Cari judul atau isi" value="<?= htmlspecialchars($filters['q'] ?? '') ?>">
            </div>
            <div class="col-sm-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <?php foreach ($statusOptions as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($filters['status'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-3">
                <select name="prioritas" class="form-select">
                    <option value="">Semua Prioritas</option>
                    <?php foreach ($prioritasOptions as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($filters['prioritas'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>Dipublikasikan</th>
                    <th>Berakhir</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($pagination['data'])): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data pengumuman.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pagination['data'] as $index => $pengumuman): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) ($pagination['perPage'] * ($pagination['currentPage'] - 1) + $index + 1)) ?></td>
                            <td><?= htmlspecialchars($pengumuman['judul']) ?></td>
                            <td>
                                <span class="badge bg-<?= $pengumuman['status'] === 'diterbitkan' ? 'success' : ($pengumuman['status'] === 'draf' ? 'secondary' : 'warning') ?>">
                                    <?= htmlspecialchars(ucfirst($pengumuman['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= $pengumuman['prioritas'] === 'tinggi' ? 'danger' : ($pengumuman['prioritas'] === 'rendah' ? 'secondary' : 'info') ?>">
                                    <?= htmlspecialchars(ucfirst($pengumuman['prioritas'])) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($pengumuman['dipublikasikan_pada'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($pengumuman['berakhir_pada'] ?? '-') ?></td>
                            <td>
                                <a href="/pengumuman/<?= $pengumuman['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="/pengumuman/<?= $pengumuman['id'] ?>/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="/pengumuman/<?= $pengumuman['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (($pagination['lastPage'] ?? 1) > 1): ?>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $pagination['lastPage']; $i++): ?>
                        <li class="page-item <?= $i === $pagination['currentPage'] ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($filters['q'] ?? '') ?>&status=<?= urlencode($filters['status'] ?? '') ?>&prioritas=<?= urlencode($filters['prioritas'] ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
