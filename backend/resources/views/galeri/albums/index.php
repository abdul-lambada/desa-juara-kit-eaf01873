<?php
/** @var array $pagination */
/** @var array $filters */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Album Galeri</h6>
        <a href="/galeri/albums/create" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Album
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-sm-4">
                <input type="text" name="q" class="form-control" placeholder="Cari judul album" value="<?= htmlspecialchars($filters['q'] ?? '') ?>">
            </div>
            <div class="col-sm-3">
                <select name="unggulan" class="form-select">
                    <option value="">Semua Album</option>
                    <option value="1" <?= ($filters['unggulan'] ?? '') === '1' ? 'selected' : '' ?>>Unggulan</option>
                    <option value="0" <?= ($filters['unggulan'] ?? '') === '0' ? 'selected' : '' ?>>Non Unggulan</option>
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
                    <th>Diterbitkan</th>
                    <th>Unggulan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($pagination['data'])): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada album galeri.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pagination['data'] as $index => $album): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) ($pagination['perPage'] * ($pagination['currentPage'] - 1) + $index + 1)) ?></td>
                            <td><?= htmlspecialchars($album['title']) ?></td>
                            <td><?= htmlspecialchars($album['published_at'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($album['is_featured'])): ?>
                                    <span class="badge bg-primary">Unggulan</span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/galeri/albums/<?= $album['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="/galeri/albums/<?= $album['id'] ?>/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="/galeri/albums/<?= $album['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus album ini?');">
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
                            <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($filters['q'] ?? '') ?>&unggulan=<?= urlencode($filters['unggulan'] ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
