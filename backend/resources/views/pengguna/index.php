<?php
/** @var array $pagination */
/** @var array $filters */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
        <a href="/pengguna/create" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-sm-4">
                <input type="text" name="q" class="form-control" placeholder="Cari nama atau email" value="<?= htmlspecialchars($filters['q'] ?? '') ?>">
            </div>
            <div class="col-sm-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <?php foreach (['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif', 'diblokir' => 'Diblokir'] as $value => $label): ?>
                        <option value="<?= $value ?>" <?= (($filters['status'] ?? '') === $value) ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($pagination['data'])): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data pengguna.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pagination['data'] as $index => $pengguna): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) ($pagination['perPage'] * ($pagination['currentPage'] - 1) + $index + 1)) ?></td>
                            <td><?= htmlspecialchars($pengguna['nama']) ?></td>
                            <td><?= htmlspecialchars($pengguna['email']) ?></td>
                            <td><?= htmlspecialchars($pengguna['telepon'] ?? '-') ?></td>
                            <td>
                                <span class="badge bg-<?= $pengguna['status'] === 'aktif' ? 'success' : ($pengguna['status'] === 'diblokir' ? 'danger' : 'secondary') ?>">
                                    <?= htmlspecialchars(ucfirst($pengguna['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <a href="/pengguna/<?= $pengguna['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="/pengguna/<?= $pengguna['id'] ?>/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="/pengguna/<?= $pengguna['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
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
                            <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($filters['q'] ?? '') ?>&status=<?= urlencode($filters['status'] ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
