<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\TransparencyYear;

class TransparencyYearController extends Controller
{
    protected TransparencyYear $years;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->years = new TransparencyYear($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'tahun' => trim((string) $this->request->input('tahun', '')),
        ];

        $pagination = $this->years->paginate($this->desaId, $page, 10, $filters);

        return view('transparansi/tahun/index', [
            'title' => 'Transparansi Anggaran',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Transparansi'],
            ],
            'filters' => $filters,
            'pagination' => $pagination,
        ]);
    }

    public function create(): mixed
    {
        return view('transparansi/tahun/create', [
            'title' => 'Tambah Tahun Anggaran',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Transparansi', 'url' => '/transparansi/tahun'],
                ['label' => 'Tambah'],
            ],
            'year' => $this->defaultData(),
            'formAction' => '/transparansi/tahun',
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
            return redirect('/transparansi/tahun/create');
        }

        $input['village_id'] = $this->desaId;
        $this->years->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Tahun anggaran berhasil ditambahkan.');
        return redirect('/transparansi/tahun');
    }

    public function show(): mixed
    {
        $year = $this->findOrRedirect();
        if (!$year) {
            return redirect('/transparansi/tahun');
        }

        return view('transparansi/tahun/show', [
            'title' => 'Detail Tahun Anggaran',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Transparansi', 'url' => '/transparansi/tahun'],
                ['label' => $year['fiscal_year']],
            ],
            'year' => $year,
        ]);
    }

    public function edit(): mixed
    {
        $year = $this->findOrRedirect();
        if (!$year) {
            return redirect('/transparansi/tahun');
        }

        return view('transparansi/tahun/edit', [
            'title' => 'Ubah Tahun Anggaran',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Transparansi', 'url' => '/transparansi/tahun'],
                ['label' => 'Ubah'],
            ],
            'year' => $year,
            'formAction' => '/transparansi/tahun/' . $year['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $year = $this->findOrRedirect();
        if (!$year) {
            return redirect('/transparansi/tahun');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/transparansi/tahun/' . $year['id'] . '/edit');
        }

        $input['updated_at'] = date('Y-m-d H:i:s');
        $this->years->updateYear($year['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Tahun anggaran berhasil diperbarui.');
        return redirect('/transparansi/tahun');
    }

    public function destroy(): mixed
    {
        $year = $this->findOrRedirect();
        if (!$year) {
            return redirect('/transparansi/tahun');
        }

        $this->years->delete($year['id']);

        session()->flash('success', 'Tahun anggaran berhasil dihapus.');
        return redirect('/transparansi/tahun');
    }

    protected function prepareInput(): array
    {
        return [
            'fiscal_year' => (int) $this->request->input('fiscal_year', 0),
            'description' => trim((string) $this->request->input('description', '')),
            'is_published' => (int) (bool) $this->request->input('is_published', false),
        ];
    }

    protected function validate(array &$data): array
    {
        $errors = [];

        if ($data['fiscal_year'] <= 0) {
            $errors[] = 'Tahun anggaran wajib diisi dengan angka yang valid.';
        }

        return $errors;
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data tahun anggaran tidak ditemukan.');
            return null;
        }

        $year = $this->years->findForDesa($id, $this->desaId);

        if (!$year) {
            session()->flash('error', 'Data tahun anggaran tidak ditemukan.');
            return null;
        }

        return $year;
    }

    protected function defaultData(): array
    {
        return [
            'fiscal_year' => date('Y'),
            'description' => '',
            'is_published' => 0,
        ];
    }
}
