<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Snapshot Statistik</h6>
        <a href="/statistik/create" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Snapshot
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-sm-4 col-md-3">
                <input type="text" name="periode" class="form-control" placeholder="Filter periode" value="<?= htmlspecialchars($filters['periode'] ?? '') ?>">
            </div>
            <div class="col-sm-3 col-md-2">
                <input type="number" name="tahun" class="form-control" placeholder="Tahun" value="<?= htmlspecialchars($filters['tahun'] ?? '') ?>">
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
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>Total Penduduk</th>
                    <th>Jumlah KK</th>
                    <th>L / P</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($pagination['data'])): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada snapshot statistik.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pagination['data'] as $index => $row): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) ($pagination['perPage'] * ($pagination['currentPage'] - 1) + $index + 1)) ?></td>
                            <td><?= htmlspecialchars($row['periode']) ?></td>
                            <td><?= htmlspecialchars($row['tahun'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['total_penduduk'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['jumlah_kk'] ?? '-') ?></td>
                            <td><?= htmlspecialchars(($row['penduduk_laki'] ?? 0)) ?> / <?= htmlspecialchars(($row['penduduk_perempuan'] ?? 0)) ?></td>
                            <td><?= htmlspecialchars($row['dibuat_pada'] ?? '-') ?></td>
                            <td>
                                <a href="/statistik/<?= $row['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="/statistik/<?= $row['id'] ?>/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="/statistik/<?= $row['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus snapshot ini?');">
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
                            <a class="page-link" href="?page=<?= $i ?>&periode=<?= urlencode($filters['periode'] ?? '') ?>&tahun=<?= urlencode($filters['tahun'] ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
