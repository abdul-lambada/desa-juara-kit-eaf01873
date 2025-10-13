<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\StatisticsAgeGroup;
use App\Models\StatisticsEducation;
use App\Models\StatisticsOccupation;
use App\Models\StatisticsSnapshot;

class StatisticsSnapshotController extends Controller
{
    protected StatisticsSnapshot $snapshots;
    protected StatisticsAgeGroup $ageGroups;
    protected StatisticsEducation $educations;
    protected StatisticsOccupation $occupations;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->snapshots = new StatisticsSnapshot($database);
        $this->ageGroups = new StatisticsAgeGroup($database);
        $this->educations = new StatisticsEducation($database);
        $this->occupations = new StatisticsOccupation($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'periode' => trim((string) $this->request->input('periode', '')),
            'tahun' => trim((string) $this->request->input('tahun', '')),
        ];

        if ($filters['tahun'] === '') {
            unset($filters['tahun']);
        }

        $pagination = $this->snapshots->paginate($this->desaId, $page, 10, $filters);

        return view('statistik/index', [
            'title' => 'Statistik Desa',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Statistik'],
            ],
            'filters' => $filters,
            'pagination' => $pagination,
        ]);
    }

    public function create(): mixed
    {
        return view('statistik/create', [
            'title' => 'Tambah Snapshot Statistik',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Statistik', 'url' => '/statistik'],
                ['label' => 'Tambah'],
            ],
            'snapshot' => $this->defaultSnapshotData(),
            'formAction' => '/statistik',
            'formMethod' => 'POST',
            'submitLabel' => 'Simpan',
            'ageGroups' => [],
            'educations' => [],
            'occupations' => [],
        ]);
    }

    public function store(): mixed
    {
        $input = $this->prepareSnapshotInput();
        $errors = $this->validateSnapshot($input);

        if (!empty($errors)) {
            session()->setOldInput(array_merge(
                ['form' => 'snapshot'],
                $this->request->only([
                    'periode',
                    'tahun',
                    'total_penduduk',
                    'jumlah_kk',
                    'penduduk_laki',
                    'penduduk_perempuan',
                ])
            ));
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/create');
        }

        $input['desa_id'] = $this->desaId;
        $this->snapshots->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Snapshot statistik berhasil ditambahkan.');
        return redirect('/statistik');
    }

    public function show(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $snapshot['age_groups'] = $this->ageGroups->listForSnapshot($snapshot['id']);
        $snapshot['educations'] = $this->educations->listForSnapshot($snapshot['id']);
        $snapshot['occupations'] = $this->occupations->listForSnapshot($snapshot['id']);

        return view('statistik/show', [
            'title' => 'Detail Snapshot Statistik',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Statistik', 'url' => '/statistik'],
                ['label' => $snapshot['periode']],
            ],
            'snapshot' => $snapshot,
            'ageGroups' => $snapshot['age_groups'],
            'educations' => $snapshot['educations'],
            'occupations' => $snapshot['occupations'],
        ]);
    }

    public function edit(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $snapshot['age_groups'] = $this->ageGroups->listForSnapshot($snapshot['id']);
        $snapshot['educations'] = $this->educations->listForSnapshot($snapshot['id']);
        $snapshot['occupations'] = $this->occupations->listForSnapshot($snapshot['id']);

        return view('statistik/edit', [
            'title' => 'Ubah Snapshot Statistik',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Statistik', 'url' => '/statistik'],
                ['label' => 'Ubah'],
            ],
            'snapshot' => $snapshot,
            'formAction' => '/statistik/' . $snapshot['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
            'ageGroups' => $snapshot['age_groups'],
            'educations' => $snapshot['educations'],
            'occupations' => $snapshot['occupations'],
        ]);
    }

    public function update(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $input = $this->prepareSnapshotInput();
        $errors = $this->validateSnapshot($input, $snapshot['id']);

        if (!empty($errors)) {
            session()->setOldInput(array_merge(
                ['form' => 'snapshot', 'form_id' => $snapshot['id']],
                $this->request->only([
                    'periode',
                    'tahun',
                    'total_penduduk',
                    'jumlah_kk',
                    'penduduk_laki',
                    'penduduk_perempuan',
                ])
            ));
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $input['diperbarui_pada'] = date('Y-m-d H:i:s');
        $this->snapshots->updateSnapshot($snapshot['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Snapshot statistik berhasil diperbarui.');
        return redirect('/statistik');
    }

    public function destroy(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $this->snapshots->delete($snapshot['id']);

        session()->flash('success', 'Snapshot statistik berhasil dihapus.');
        return redirect('/statistik');
    }

    public function storeAgeGroup(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $input = $this->prepareAgeGroupInput($snapshot['id']);
        $errors = $this->validateAgeGroup($input);

        if (!empty($errors)) {
            session()->setOldInput([
                'form' => 'age_create',
                'form_id' => $snapshot['id'],
                'age_label' => (string) $this->request->input('age_label', ''),
                'age_jumlah' => (string) $this->request->input('age_jumlah', ''),
                'age_urutan' => (string) $this->request->input('age_urutan', ''),
            ]);
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->ageGroups->insert($input);

        session()->setOldInput([]);
        session()->flash('success', 'Kelompok usia berhasil ditambahkan.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function updateAgeGroup(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $ageGroup = $this->ageGroups->findForSnapshot((int) $this->request->route('group'), $snapshot['id']);
        if (!$ageGroup) {
            session()->flash('error', 'Kelompok usia tidak ditemukan.');
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $input = $this->prepareAgeGroupInput($snapshot['id']);
        $errors = $this->validateAgeGroup($input, $ageGroup['id']);

        if (!empty($errors)) {
            session()->setOldInput([
                'form' => 'age_update',
                'form_id' => $snapshot['id'],
                'group_id' => $ageGroup['id'],
                'age_label' => (string) $this->request->input('age_label', ''),
                'age_jumlah' => (string) $this->request->input('age_jumlah', ''),
                'age_urutan' => (string) $this->request->input('age_urutan', ''),
            ]);
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->ageGroups->update($ageGroup['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Kelompok usia berhasil diperbarui.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function destroyAgeGroup(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $ageGroup = $this->ageGroups->findForSnapshot((int) $this->request->route('group'), $snapshot['id']);
        if (!$ageGroup) {
            session()->flash('error', 'Kelompok usia tidak ditemukan.');
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->ageGroups->delete($ageGroup['id']);

        session()->flash('success', 'Kelompok usia berhasil dihapus.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function storeEducation(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $input = $this->prepareEducationInput($snapshot['id']);
        $errors = $this->validateEducation($input);

        if (!empty($errors)) {
            session()->setOldInput([
                'form' => 'education_create',
                'form_id' => $snapshot['id'],
                'education_jenjang' => (string) $this->request->input('education_jenjang', ''),
                'education_jumlah' => (string) $this->request->input('education_jumlah', ''),
                'education_urutan' => (string) $this->request->input('education_urutan', ''),
            ]);
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->educations->insert($input);

        session()->setOldInput([]);
        session()->flash('success', 'Data pendidikan berhasil ditambahkan.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function updateEducation(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $education = $this->educations->findForSnapshot((int) $this->request->route('education'), $snapshot['id']);
        if (!$education) {
            session()->flash('error', 'Data pendidikan tidak ditemukan.');
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $input = $this->prepareEducationInput($snapshot['id']);
        $errors = $this->validateEducation($input, $education['id']);

        if (!empty($errors)) {
            session()->setOldInput([
                'form' => 'education_update',
                'form_id' => $snapshot['id'],
                'education_id' => $education['id'],
                'education_jenjang' => (string) $this->request->input('education_jenjang', ''),
                'education_jumlah' => (string) $this->request->input('education_jumlah', ''),
                'education_urutan' => (string) $this->request->input('education_urutan', ''),
            ]);
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->educations->update($education['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Data pendidikan berhasil diperbarui.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function destroyEducation(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $education = $this->educations->findForSnapshot((int) $this->request->route('education'), $snapshot['id']);
        if (!$education) {
            session()->flash('error', 'Data pendidikan tidak ditemukan.');
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->educations->delete($education['id']);

        session()->flash('success', 'Data pendidikan berhasil dihapus.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function storeOccupation(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $input = $this->prepareOccupationInput($snapshot['id']);
        $errors = $this->validateOccupation($input);

        if (!empty($errors)) {
            session()->setOldInput([
                'form' => 'occupation_create',
                'form_id' => $snapshot['id'],
                'occupation_nama' => (string) $this->request->input('occupation_nama', ''),
                'occupation_jumlah' => (string) $this->request->input('occupation_jumlah', ''),
                'occupation_persentase' => (string) $this->request->input('occupation_persentase', ''),
                'occupation_urutan' => (string) $this->request->input('occupation_urutan', ''),
            ]);
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->occupations->insert($input);

        session()->setOldInput([]);
        session()->flash('success', 'Data pekerjaan berhasil ditambahkan.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function updateOccupation(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $occupation = $this->occupations->findForSnapshot((int) $this->request->route('occupation'), $snapshot['id']);
        if (!$occupation) {
            session()->flash('error', 'Data pekerjaan tidak ditemukan.');
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $input = $this->prepareOccupationInput($snapshot['id']);
        $errors = $this->validateOccupation($input, $occupation['id']);

        if (!empty($errors)) {
            session()->setOldInput([
                'form' => 'occupation_update',
                'form_id' => $snapshot['id'],
                'occupation_id' => $occupation['id'],
                'occupation_nama' => (string) $this->request->input('occupation_nama', ''),
                'occupation_jumlah' => (string) $this->request->input('occupation_jumlah', ''),
                'occupation_persentase' => (string) $this->request->input('occupation_persentase', ''),
                'occupation_urutan' => (string) $this->request->input('occupation_urutan', ''),
            ]);
            session()->flash('error', implode(' ', $errors));
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->occupations->update($occupation['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Data pekerjaan berhasil diperbarui.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    public function destroyOccupation(): mixed
    {
        $snapshot = $this->findSnapshotOrRedirect();
        if (!$snapshot) {
            return redirect('/statistik');
        }

        $occupation = $this->occupations->findForSnapshot((int) $this->request->route('occupation'), $snapshot['id']);
        if (!$occupation) {
            session()->flash('error', 'Data pekerjaan tidak ditemukan.');
            return redirect('/statistik/' . $snapshot['id'] . '/edit');
        }

        $this->occupations->delete($occupation['id']);

        session()->flash('success', 'Data pekerjaan berhasil dihapus.');
        return redirect('/statistik/' . $snapshot['id'] . '/edit');
    }

    protected function prepareSnapshotInput(): array
    {
        return [
            'periode' => trim((string) $this->request->input('periode', '')),
            'tahun' => $this->prepareIntInput('tahun'),
            'total_penduduk' => $this->prepareIntInput('total_penduduk'),
            'jumlah_kk' => $this->prepareIntInput('jumlah_kk'),
            'penduduk_laki' => $this->prepareIntInput('penduduk_laki'),
            'penduduk_perempuan' => $this->prepareIntInput('penduduk_perempuan'),
        ];
    }

    protected function validateSnapshot(array $data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['periode'] === '') {
            $errors[] = 'Periode wajib diisi.';
        }

        if ($data['periode'] !== '' && $this->snapshots->periodeExists($this->desaId, $data['periode'], $id)) {
            $errors[] = 'Periode statistik sudah digunakan.';
        }

        if ($data['tahun'] !== null && $data['tahun'] < 1900) {
            $errors[] = 'Tahun tidak valid.';
        }

        if ($data['total_penduduk'] !== null && $data['total_penduduk'] < 0) {
            $errors[] = 'Total penduduk tidak boleh negatif.';
        }

        if ($data['jumlah_kk'] !== null && $data['jumlah_kk'] < 0) {
            $errors[] = 'Jumlah KK tidak boleh negatif.';
        }

        if ($data['penduduk_laki'] !== null && $data['penduduk_laki'] < 0) {
            $errors[] = 'Jumlah penduduk laki-laki tidak boleh negatif.';
        }

        if ($data['penduduk_perempuan'] !== null && $data['penduduk_perempuan'] < 0) {
            $errors[] = 'Jumlah penduduk perempuan tidak boleh negatif.';
        }

        return $errors;
    }

    protected function prepareAgeGroupInput(int $snapshotId): array
    {
        return [
            'snapshot_id' => $snapshotId,
            'label' => trim((string) $this->request->input('age_label', $this->request->input('label', ''))),
            'jumlah' => $this->prepareIntInput('age_jumlah', $this->prepareIntInput('jumlah')),
            'urutan' => $this->prepareIntInput('age_urutan', $this->prepareIntInput('urutan', 1)) ?? 1,
        ];
    }

    protected function validateAgeGroup(array $data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['label'] === '') {
            $errors[] = 'Label kelompok usia wajib diisi.';
        }

        if ($data['jumlah'] === null || $data['jumlah'] < 0) {
            $errors[] = 'Jumlah kelompok usia wajib diisi dan tidak boleh negatif.';
        }

        if ($data['urutan'] === null || $data['urutan'] < 1) {
            $errors[] = 'Urutan kelompok usia wajib diisi.';
        }

        return $errors;
    }

    protected function prepareEducationInput(int $snapshotId): array
    {
        return [
            'snapshot_id' => $snapshotId,
            'jenjang' => trim((string) $this->request->input('education_jenjang', $this->request->input('jenjang', ''))),
            'jumlah' => $this->prepareIntInput('education_jumlah', $this->prepareIntInput('jumlah')),
            'urutan' => $this->prepareIntInput('education_urutan', $this->prepareIntInput('urutan', 1)) ?? 1,
        ];
    }

    protected function validateEducation(array $data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['jenjang'] === '') {
            $errors[] = 'Jenjang pendidikan wajib diisi.';
        }

        if ($data['jumlah'] === null || $data['jumlah'] < 0) {
            $errors[] = 'Jumlah pendidikan wajib diisi dan tidak boleh negatif.';
        }

        if ($data['urutan'] === null || $data['urutan'] < 1) {
            $errors[] = 'Urutan pendidikan wajib diisi.';
        }

        return $errors;
    }

    protected function prepareOccupationInput(int $snapshotId): array
    {
        return [
            'snapshot_id' => $snapshotId,
            'nama_pekerjaan' => trim((string) $this->request->input('occupation_nama', $this->request->input('nama_pekerjaan', ''))),
            'jumlah' => $this->prepareIntInput('occupation_jumlah', $this->prepareIntInput('jumlah')),
            'persentase' => $this->prepareNumericInput('occupation_persentase', $this->prepareNumericInput('persentase')),
            'urutan' => $this->prepareIntInput('occupation_urutan', $this->prepareIntInput('urutan', 1)) ?? 1,
        ];
    }

    protected function validateOccupation(array $data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['nama_pekerjaan'] === '') {
            $errors[] = 'Nama pekerjaan wajib diisi.';
        }

        if ($data['jumlah'] !== null && $data['jumlah'] < 0) {
            $errors[] = 'Jumlah pekerjaan tidak boleh negatif.';
        }

        if ($data['persentase'] !== null && ($data['persentase'] < 0 || $data['persentase'] > 100)) {
            $errors[] = 'Persentase pekerjaan harus antara 0 sampai 100.';
        }

        if ($data['urutan'] === null || $data['urutan'] < 1) {
            $errors[] = 'Urutan pekerjaan wajib diisi.';
        }

        return $errors;
    }

    protected function findSnapshotOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data snapshot tidak ditemukan.');
            return null;
        }

        $snapshot = $this->snapshots->findForDesa($id, $this->desaId);

        if (!$snapshot) {
            session()->flash('error', 'Data snapshot tidak ditemukan.');
            return null;
        }

        return $snapshot;
    }

    protected function defaultSnapshotData(): array
    {
        return [
            'periode' => '',
            'tahun' => date('Y'),
            'total_penduduk' => null,
            'jumlah_kk' => null,
            'penduduk_laki' => null,
            'penduduk_perempuan' => null,
            'age_groups' => [],
            'educations' => [],
            'occupations' => [],
        ];
    }

    protected function prepareIntInput(string $key, ?int $default = null): ?int
    {
        $value = trim((string) $this->request->input($key, ''));
        if ($value === '') {
            return $default;
        }

        return is_numeric($value) ? (int) $value : $default;
    }

    protected function prepareNumericInput(string $key, ?float $default = null): ?float
    {
        $value = trim((string) $this->request->input($key, ''));
        if ($value === '') {
            return $default;
        }

        return is_numeric($value) ? (float) $value : $default;
    }
}
