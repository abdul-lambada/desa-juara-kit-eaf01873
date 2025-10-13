<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\KategoriBerita;

class KategoriBeritaController extends Controller
{
    protected KategoriBerita $kategori;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->kategori = new KategoriBerita($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'q' => trim((string) $this->request->input('q', '')),
        ];

        $pagination = $this->kategori->paginate($this->desaId, $page, 10, $filters);

        return view('kategori-berita/index', [
            'title' => 'Kategori Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Kategori Berita'],
            ],
            'pagination' => $pagination,
            'filters' => $filters,
        ]);
    }

    public function create(): mixed
    {
        return view('kategori-berita/create', [
            'title' => 'Tambah Kategori Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Kategori Berita', 'url' => '/kategori-berita'],
                ['label' => 'Tambah'],
            ],
            'kategori' => $this->defaultData(),
            'formAction' => '/kategori-berita',
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
            return redirect('/kategori-berita/create');
        }

        $input['desa_id'] = $this->desaId;
        $this->kategori->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Kategori berhasil ditambahkan.');
        return redirect('/kategori-berita');
    }

    public function show(): mixed
    {
        $kategori = $this->findOrRedirect();
        if (!$kategori) {
            return redirect('/kategori-berita');
        }

        return view('kategori-berita/show', [
            'title' => 'Detail Kategori Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Kategori Berita', 'url' => '/kategori-berita'],
                ['label' => $kategori['nama']],
            ],
            'kategori' => $kategori,
        ]);
    }

    public function edit(): mixed
    {
        $kategori = $this->findOrRedirect();
        if (!$kategori) {
            return redirect('/kategori-berita');
        }

        return view('kategori-berita/edit', [
            'title' => 'Ubah Kategori Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Kategori Berita', 'url' => '/kategori-berita'],
                ['label' => 'Ubah'],
            ],
            'kategori' => $kategori,
            'formAction' => '/kategori-berita/' . $kategori['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $kategori = $this->findOrRedirect();
        if (!$kategori) {
            return redirect('/kategori-berita');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input, $kategori['id']);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/kategori-berita/' . $kategori['id'] . '/edit');
        }

        $input['desa_id'] = $this->desaId;
        $input['diperbarui_pada'] = date('Y-m-d H:i:s');
        $this->kategori->updateWithSlug($kategori['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Kategori berhasil diperbarui.');
        return redirect('/kategori-berita');
    }

    public function destroy(): mixed
    {
        $kategori = $this->findOrRedirect();
        if (!$kategori) {
            return redirect('/kategori-berita');
        }

        $this->kategori->delete($kategori['id']);

        session()->flash('success', 'Kategori berhasil dihapus.');
        return redirect('/kategori-berita');
    }

    protected function prepareInput(): array
    {
        return [
            'nama' => trim((string) $this->request->input('nama', '')),
            'deskripsi' => trim((string) $this->request->input('deskripsi', '')),
        ];
    }

    protected function validate(array &$data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['nama'] === '') {
            $errors[] = 'Nama kategori wajib diisi.';
        }

        return $errors;
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data kategori tidak ditemukan.');
            return null;
        }

        $kategori = $this->kategori->findForDesa($id, $this->desaId);

        if (!$kategori) {
            session()->flash('error', 'Data kategori tidak ditemukan.');
            return null;
        }

        return $kategori;
    }

    protected function defaultData(): array
    {
        return [
            'nama' => '',
            'deskripsi' => '',
        ];
    }
}
