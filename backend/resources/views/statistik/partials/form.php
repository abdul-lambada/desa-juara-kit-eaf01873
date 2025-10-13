<?php
$session = session();
$currentSnapshotId = $snapshot['id'] ?? null;
$ageGroups = $ageGroups ?? [];
$educations = $educations ?? [];
$occupations = $occupations ?? [];
$oldInput = $session->oldInput();
$oldForm = $oldInput['form'] ?? null;
$oldFormSnapshot = $oldInput['form_id'] ?? null;
$matchesSnapshot = $oldFormSnapshot === null || ($currentSnapshotId !== null && (int) $oldFormSnapshot === (int) $currentSnapshotId);
$httpMethod = strtoupper($formMethod ?? 'POST');

$useSnapshotOld = $matchesSnapshot && $oldForm === 'snapshot';

$snapshotValues = [
    'periode' => $useSnapshotOld ? ($oldInput['periode'] ?? '') : ($snapshot['periode'] ?? ''),
    'tahun' => $useSnapshotOld ? ($oldInput['tahun'] ?? '') : ($snapshot['tahun'] ?? ''),
    'total_penduduk' => $useSnapshotOld ? ($oldInput['total_penduduk'] ?? '') : ($snapshot['total_penduduk'] ?? ''),
    'jumlah_kk' => $useSnapshotOld ? ($oldInput['jumlah_kk'] ?? '') : ($snapshot['jumlah_kk'] ?? ''),
    'penduduk_laki' => $useSnapshotOld ? ($oldInput['penduduk_laki'] ?? '') : ($snapshot['penduduk_laki'] ?? ''),
    'penduduk_perempuan' => $useSnapshotOld ? ($oldInput['penduduk_perempuan'] ?? '') : ($snapshot['penduduk_perempuan'] ?? ''),
];

$ageCreateOld = ($matchesSnapshot && $oldForm === 'age_create') ? [
    'label' => $session->old('age_label', ''),
    'jumlah' => $session->old('age_jumlah', ''),
    'urutan' => $session->old('age_urutan', ''),
] : ['label' => '', 'jumlah' => '', 'urutan' => ''];

$ageUpdateOld = [];
if ($matchesSnapshot && $oldForm === 'age_update') {
    $target = (int) ($oldInput['group_id'] ?? 0);
    if ($target > 0) {
        $ageUpdateOld[$target] = [
            'label' => $session->old('age_label', ''),
            'jumlah' => $session->old('age_jumlah', ''),
            'urutan' => $session->old('age_urutan', ''),
        ];
    }
}

$educationCreateOld = ($matchesSnapshot && $oldForm === 'education_create') ? [
    'jenjang' => $session->old('education_jenjang', ''),
    'jumlah' => $session->old('education_jumlah', ''),
    'urutan' => $session->old('education_urutan', ''),
] : ['jenjang' => '', 'jumlah' => '', 'urutan' => ''];

$educationUpdateOld = [];
if ($matchesSnapshot && $oldForm === 'education_update') {
    $target = (int) ($oldInput['education_id'] ?? 0);
    if ($target > 0) {
        $educationUpdateOld[$target] = [
            'jenjang' => $session->old('education_jenjang', ''),
            'jumlah' => $session->old('education_jumlah', ''),
            'urutan' => $session->old('education_urutan', ''),
        ];
    }
}

$occupationCreateOld = ($matchesSnapshot && $oldForm === 'occupation_create') ? [
    'nama' => $session->old('occupation_nama', ''),
    'jumlah' => $session->old('occupation_jumlah', ''),
    'persentase' => $session->old('occupation_persentase', ''),
    'urutan' => $session->old('occupation_urutan', ''),
] : ['nama' => '', 'jumlah' => '', 'persentase' => '', 'urutan' => ''];

$occupationUpdateOld = [];
if ($matchesSnapshot && $oldForm === 'occupation_update') {
    $target = (int) ($oldInput['occupation_id'] ?? 0);
    if ($target > 0) {
        $occupationUpdateOld[$target] = [
            'nama' => $session->old('occupation_nama', ''),
            'jumlah' => $session->old('occupation_jumlah', ''),
            'persentase' => $session->old('occupation_persentase', ''),
            'urutan' => $session->old('occupation_urutan', ''),
        ];
    }
}
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Snapshot Statistik</h6>
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars($formAction) ?>" method="POST">
                    <?php if (!in_array($httpMethod, ['GET', 'POST'], true)): ?>
                        <input type="hidden" name="_method" value="<?= htmlspecialchars($httpMethod) ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" name="periode" class="form-control" value="<?= htmlspecialchars((string) $snapshotValues['periode']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars((string) $snapshotValues['tahun']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Penduduk</label>
                                <input type="number" name="total_penduduk" class="form-control" value="<?= htmlspecialchars((string) $snapshotValues['total_penduduk']) ?>" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jumlah KK</label>
                                <input type="number" name="jumlah_kk" class="form-control" value="<?= htmlspecialchars((string) $snapshotValues['jumlah_kk']) ?>" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Penduduk Laki-laki</label>
                                <input type="number" name="penduduk_laki" class="form-control" value="<?= htmlspecialchars((string) $snapshotValues['penduduk_laki']) ?>" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Penduduk Perempuan</label>
                                <input type="number" name="penduduk_perempuan" class="form-control" value="<?= htmlspecialchars((string) $snapshotValues['penduduk_perempuan']) ?>" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/statistik" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($currentSnapshotId): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelompok Usia</h6>
        </div>
        <div class="card-body">
            <form action="/statistik/<?= $currentSnapshotId ?>/age-groups" method="POST" class="row g-2 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label small">Label</label>
                    <input type="text" name="age_label" class="form-control" value="<?= htmlspecialchars((string) $ageCreateOld['label']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="age_jumlah" class="form-control" value="<?= htmlspecialchars((string) $ageCreateOld['jumlah']) ?>" min="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Urutan</label>
                    <input type="number" name="age_urutan" class="form-control" value="<?= htmlspecialchars((string) $ageCreateOld['urutan']) ?>" min="1" required>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </form>

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
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ageGroups as $group): ?>
                            <?php $groupId = (int) ($group['id'] ?? 0); ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $group['label']) ?></td>
                                <td><?= htmlspecialchars((string) $group['jumlah']) ?></td>
                                <td><?= htmlspecialchars((string) $group['urutan']) ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <form action="/statistik/<?= $currentSnapshotId ?>/age-groups/<?= $groupId ?>" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="text" name="age_label" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($ageUpdateOld[$groupId]['label'] ?? $group['label'])) ?>" required>
                                            <input type="number" name="age_jumlah" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($ageUpdateOld[$groupId]['jumlah'] ?? $group['jumlah'])) ?>" min="0" required>
                                            <input type="number" name="age_urutan" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($ageUpdateOld[$groupId]['urutan'] ?? $group['urutan'])) ?>" min="1" required>
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                                        </form>
                                        <form action="/statistik/<?= $currentSnapshotId ?>/age-groups/<?= $groupId ?>" method="POST" onsubmit="return confirm('Hapus kelompok usia ini?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
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
            <h6 class="m-0 font-weight-bold text-primary">Pendidikan</h6>
        </div>
        <div class="card-body">
            <form action="/statistik/<?= $currentSnapshotId ?>/educations" method="POST" class="row g-2 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label small">Jenjang</label>
                    <input type="text" name="education_jenjang" class="form-control" value="<?= htmlspecialchars((string) $educationCreateOld['jenjang']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="education_jumlah" class="form-control" value="<?= htmlspecialchars((string) $educationCreateOld['jumlah']) ?>" min="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Urutan</label>
                    <input type="number" name="education_urutan" class="form-control" value="<?= htmlspecialchars((string) $educationCreateOld['urutan']) ?>" min="1" required>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </form>

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
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($educations as $education): ?>
                            <?php $educationId = (int) ($education['id'] ?? 0); ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $education['jenjang']) ?></td>
                                <td><?= htmlspecialchars((string) $education['jumlah']) ?></td>
                                <td><?= htmlspecialchars((string) $education['urutan']) ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <form action="/statistik/<?= $currentSnapshotId ?>/educations/<?= $educationId ?>" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="text" name="education_jenjang" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($educationUpdateOld[$educationId]['jenjang'] ?? $education['jenjang'])) ?>" required>
                                            <input type="number" name="education_jumlah" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($educationUpdateOld[$educationId]['jumlah'] ?? $education['jumlah'])) ?>" min="0" required>
                                            <input type="number" name="education_urutan" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($educationUpdateOld[$educationId]['urutan'] ?? $education['urutan'])) ?>" min="1" required>
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                                        </form>
                                        <form action="/statistik/<?= $currentSnapshotId ?>/educations/<?= $educationId ?>" method="POST" onsubmit="return confirm('Hapus data pendidikan ini?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
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
            <h6 class="m-0 font-weight-bold text-primary">Pekerjaan</h6>
        </div>
        <div class="card-body">
            <form action="/statistik/<?= $currentSnapshotId ?>/occupations" method="POST" class="row g-2 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label small">Nama Pekerjaan</label>
                    <input type="text" name="occupation_nama" class="form-control" value="<?= htmlspecialchars((string) $occupationCreateOld['nama']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="occupation_jumlah" class="form-control" value="<?= htmlspecialchars((string) $occupationCreateOld['jumlah']) ?>" min="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Persentase</label>
                    <input type="number" step="0.01" name="occupation_persentase" class="form-control" value="<?= htmlspecialchars((string) $occupationCreateOld['persentase']) ?>" min="0" max="100">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Urutan</label>
                    <input type="number" name="occupation_urutan" class="form-control" value="<?= htmlspecialchars((string) $occupationCreateOld['urutan']) ?>" min="1" required>
                </div>
                <div class="col-md-1 text-md-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>

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
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($occupations as $occupation): ?>
                            <?php $occupationId = (int) ($occupation['id'] ?? 0); ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $occupation['nama_pekerjaan']) ?></td>
                                <td><?= htmlspecialchars((string) ($occupation['jumlah'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($occupation['persentase'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) $occupation['urutan']) ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <form action="/statistik/<?= $currentSnapshotId ?>/occupations/<?= $occupationId ?>" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="text" name="occupation_nama" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($occupationUpdateOld[$occupationId]['nama'] ?? $occupation['nama_pekerjaan'])) ?>" required>
                                            <input type="number" name="occupation_jumlah" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($occupationUpdateOld[$occupationId]['jumlah'] ?? ($occupation['jumlah'] ?? ''))) ?>" min="0">
                                            <input type="number" step="0.01" name="occupation_persentase" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($occupationUpdateOld[$occupationId]['persentase'] ?? ($occupation['persentase'] ?? ''))) ?>" min="0" max="100">
                                            <input type="number" name="occupation_urutan" class="form-control form-control-sm" value="<?= htmlspecialchars((string) ($occupationUpdateOld[$occupationId]['urutan'] ?? $occupation['urutan'])) ?>" min="1" required>
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                                        </form>
                                        <form action="/statistik/<?= $currentSnapshotId ?>/occupations/<?= $occupationId ?>" method="POST" onsubmit="return confirm('Hapus data pekerjaan ini?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
