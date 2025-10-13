<?php
/** @var array $filters */
/** @var array $pagination */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Transparansi Anggaran</h6>
        <a href="/transparansi/tahun/create" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Tahun
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-sm-3">
                <input type="number" name="tahun" class="form-control" placeholder="Filter tahun" value="<?= htmlspecialchars($filters['tahun'] ?? '') ?>">
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
                    <th>Tahun Anggaran</th>
                    <th>Publikasi</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($pagination['data'])): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data tahun anggaran.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pagination['data'] as $index => $row): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) ($pagination['perPage'] * ($pagination['currentPage'] - 1) + $index + 1)) ?></td>
                            <td><?= htmlspecialchars($row['fiscal_year']) ?></td>
                            <td>
                                <?php if (!empty($row['is_published'])): ?>
                                    <span class="badge bg-success">Dipublikasikan</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['created_at'] ?? '-') ?></td>
                            <td>
                                <a href="/transparansi/tahun/<?= $row['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="/transparansi/tahun/<?= $row['id'] ?>/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="/transparansi/tahun/<?= $row['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                            <a class="page-link" href="?page=<?= $i ?>&tahun=<?= urlencode($filters['tahun'] ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
