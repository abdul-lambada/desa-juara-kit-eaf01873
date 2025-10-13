<?php
/** @var array $album */
/** @var array $pagination */
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="font-weight-bold mb-0">Foto Album: <?= htmlspecialchars($album['title']) ?></h4>
        <p class="text-muted mb-0">Total foto: <?= htmlspecialchars((string) $pagination['total']) ?></p>
    </div>
    <a href="/galeri/albums/<?= $album['id'] ?>/photos/create" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i>Tambah Foto
    </a>
</div>

<?php if (empty($pagination['data'])): ?>
    <div class="card shadow-sm">
        <div class="card-body text-center text-muted py-5">
            Belum ada foto pada album ini.
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($pagination['data'] as $photo): ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($photo['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($photo['title']) ?>">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title font-weight-bold mb-2 text-truncate" title="<?= htmlspecialchars($photo['title']) ?>">
                            <?= htmlspecialchars($photo['title']) ?>
                        </h6>
                        <p class="text-muted small mb-3">Urutan tampilan: <?= htmlspecialchars((string) $photo['display_order']) ?></p>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="/galeri/albums/<?= $album['id'] ?>/photos/<?= $photo['id'] ?>/edit" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/galeri/albums/<?= $album['id'] ?>/photos/<?= $photo['id'] ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (($pagination['lastPage'] ?? 1) > 1): ?>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pagination['lastPage']; $i++): ?>
                    <li class="page-item <?= $i === $pagination['currentPage'] ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>
