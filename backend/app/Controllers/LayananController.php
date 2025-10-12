<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    protected Layanan $layanan;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->layanan = new Layanan($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'q' => trim((string) $this->request->input('q', '')),
            'aktif' => $this->sanitizeAktif($this->request->input('aktif', '')),
        ];

        $pagination = $this->layanan->paginate($this->desaId, $page, 10, $filters);

        return view('layanan/index', [
            'title' => 'Layanan',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Layanan'],
            ],
            'pagination' => $pagination,
            'filters' => $filters,
        ]);
    }

    public function create(): mixed
    {
        return view('layanan/create', [
            'title' => 'Tambah Layanan',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Layanan', 'url' => '/layanan'],
                ['label' => 'Tambah'],
            ],
            'layanan' => $this->defaultData(),
            'formAction' => '/layanan',
            'formMethod' => 'POST',
            'submitLabel' => 'Simpan',
        ]);
    }

    public function store(): mixed
    {
        $input = $this->prepareInput();
        $errors = $this->validate($input);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/layanan/create');
        }

        $input['desa_id'] = $this->desaId;
        $this->layanan->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Layanan berhasil ditambahkan.');
        return redirect('/layanan');
    }

    public function show(): mixed
    {
        $layanan = $this->findOrRedirect();
        if (!$layanan) {
            return redirect('/layanan');
        }

        return view('layanan/show', [
            'title' => 'Detail Layanan',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Layanan', 'url' => '/layanan'],
                ['label' => $layanan['nama']],
            ],
            'layanan' => $layanan,
        ]);
    }

    public function edit(): mixed
    {
        $layanan = $this->findOrRedirect();
        if (!$layanan) {
            return redirect('/layanan');
        }

        return view('layanan/edit', [
            'title' => 'Ubah Layanan',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Layanan', 'url' => '/layanan'],
                ['label' => 'Ubah'],
            ],
            'layanan' => $layanan,
            'formAction' => '/layanan/' . $layanan['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $layanan = $this->findOrRedirect();
        if (!$layanan) {
            return redirect('/layanan');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input, $layanan['id']);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/layanan/' . $layanan['id'] . '/edit');
        }

        $input['desa_id'] = $this->desaId;
        $input['diperbarui_pada'] = date('Y-m-d H:i:s');

        $this->layanan->updateWithSlug($layanan['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Layanan berhasil diperbarui.');
        return redirect('/layanan');
    }

    public function destroy(): mixed
    {
        $layanan = $this->findOrRedirect();
        if (!$layanan) {
            return redirect('/layanan');
        }

        $this->layanan->delete($layanan['id']);

        session()->flash('success', 'Layanan berhasil dihapus.');
        return redirect('/layanan');
    }

    protected function prepareInput(): array
    {
        $biaya = str_replace([',', ' '], ['', ''], (string) $this->request->input('biaya', ''));
        $biaya = $biaya !== '' ? (float) $biaya : null;

        return [
            'nama' => trim((string) $this->request->input('nama', '')),
            'deskripsi' => trim((string) $this->request->input('deskripsi', '')),
            'waktu_proses' => trim((string) $this->request->input('waktu_proses', '')),
            'jam_layanan' => trim((string) $this->request->input('jam_layanan', '')),
            'biaya' => $biaya,
            'keterangan_biaya' => trim((string) $this->request->input('keterangan_biaya', '')),
            'aktif' => (int) (bool) $this->request->input('aktif', true),
        ];
    }

    protected function validate(array &$data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['nama'] === '') {
            $errors[] = 'Nama layanan wajib diisi.';
        }

        if ($data['biaya'] !== null && $data['biaya'] < 0) {
            $errors[] = 'Biaya tidak boleh bernilai negatif.';
            $data['biaya'] = null;
        }

        return $errors;
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data layanan tidak ditemukan.');
            return null;
        }

        $layanan = $this->layanan->findForDesa($id, $this->desaId);

        if (!$layanan) {
            session()->flash('error', 'Data layanan tidak ditemukan.');
            return null;
        }

        return $layanan;
    }

    protected function defaultData(): array
    {
        return [
            'nama' => '',
            'deskripsi' => '',
            'waktu_proses' => '',
            'jam_layanan' => '',
            'biaya' => null,
            'keterangan_biaya' => '',
            'aktif' => 1,
        ];
    }

    protected function sanitizeAktif(mixed $aktif): string
    {
        $value = trim((string) $aktif);
        return in_array($value, ['0', '1'], true) ? $value : '';
    }
}
