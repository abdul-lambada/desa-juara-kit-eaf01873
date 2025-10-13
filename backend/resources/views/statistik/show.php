<?php
/** @var array $snapshot */
/** @var array $ageGroups */
/** @var array $educations */
/** @var array $occupations */

$formatValue = static function (mixed $value): string {
    return htmlspecialchars($value === null || $value === '' ? '-' : (string) $value);
};

$formatPercent = static function (mixed $value) use ($formatValue): string {
    if ($value === null || $value === '') {
        return $formatValue(null);
    }

    if (!is_numeric($value)) {
        return htmlspecialchars((string) $value);
    }

    $numeric = (float) $value;
    $display = fmod($numeric, 1.0) === 0.0 ? (string) (int) $numeric : rtrim(rtrim((string) $numeric, '0'), '.');
    if ($display === '') {
        $display = '0';
    }

    return htmlspecialchars($display . '%');
};
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan Statistik</h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Periode</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['periode'] ?? null) ?></dd>

                    <dt class="col-sm-5">Tahun</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['tahun'] ?? null) ?></dd>

                    <dt class="col-sm-5">Total Penduduk</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['total_penduduk'] ?? null) ?></dd>

                    <dt class="col-sm-5">Jumlah KK</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['jumlah_kk'] ?? null) ?></dd>

                    <dt class="col-sm-5">Penduduk Laki-laki</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['penduduk_laki'] ?? null) ?></dd>

                    <dt class="col-sm-5">Penduduk Perempuan</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['penduduk_perempuan'] ?? null) ?></dd>

                    <dt class="col-sm-5">Dibuat Pada</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['dibuat_pada'] ?? null) ?></dd>

                    <dt class="col-sm-5">Diperbarui Pada</dt>
                    <dd class="col-sm-7"><?= $formatValue($snapshot['diperbarui_pada'] ?? null) ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tindakan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <a href="/statistik/<?= htmlspecialchars((string) $snapshot['id']) ?>/edit" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Ubah Snapshot
                    </a>
                    <form action="/statistik/<?= htmlspecialchars((string) $snapshot['id']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus snapshot ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash"></i> Hapus Snapshot
                        </button>
                    </form>
                    <a href="/statistik" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary mb-0">Kelompok Usia</h6>
    </div>
    <div class="card-body">
        <?php if (empty($ageGroups)): ?>
            <p class="text-muted mb-0">Belum ada data kelompok usia.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Jumlah</th>
                            <th>Urutan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ageGroups as $group): ?>
                        <tr>
                            <td><?= $formatValue($group['label'] ?? null) ?></td>
                            <td><?= $formatValue($group['jumlah'] ?? null) ?></td>
                            <td><?= $formatValue($group['urutan'] ?? null) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary mb-0">Pendidikan</h6>
    </div>
    <div class="card-body">
        <?php if (empty($educations)): ?>
            <p class="text-muted mb-0">Belum ada data pendidikan.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Jenjang</th>
                            <th>Jumlah</th>
                            <th>Urutan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($educations as $education): ?>
                        <tr>
                            <td><?= $formatValue($education['jenjang'] ?? null) ?></td>
                            <td><?= $formatValue($education['jumlah'] ?? null) ?></td>
                            <td><?= $formatValue($education['urutan'] ?? null) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary mb-0">Pekerjaan</h6>
    </div>
    <div class="card-body">
        <?php if (empty($occupations)): ?>
            <p class="text-muted mb-0">Belum ada data pekerjaan.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Persentase</th>
                            <th>Urutan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($occupations as $occupation): ?>
                        <tr>
                            <td><?= $formatValue($occupation['nama_pekerjaan'] ?? null) ?></td>
                            <td><?= $formatValue($occupation['jumlah'] ?? null) ?></td>
                            <td><?= $formatPercent($occupation['persentase'] ?? null) ?></td>
                            <td><?= $formatValue($occupation['urutan'] ?? null) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
