<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\Berita;
use App\Models\KategoriBerita;

class BeritaController extends Controller
{
    protected Berita $berita;
    protected KategoriBerita $kategori;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->berita = new Berita($database);
        $this->kategori = new KategoriBerita($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'q' => trim((string) $this->request->input('q', '')),
            'status' => $this->sanitizeStatus($this->request->input('status', ''), ''),
            'kategori_id' => (int) $this->request->input('kategori_id', 0) ?: null,
        ];

        $pagination = $this->berita->paginate($this->desaId, $page, 10, $filters);

        return view('berita/index', [
            'title' => 'Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Berita'],
            ],
            'pagination' => $pagination,
            'filters' => $filters,
            'kategoriOptions' => $this->kategori->options($this->desaId),
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function create(): mixed
    {
        return view('berita/create', [
            'title' => 'Tambah Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Berita', 'url' => '/berita'],
                ['label' => 'Tambah'],
            ],
            'berita' => $this->defaultData(),
            'kategoriOptions' => $this->kategori->options($this->desaId),
            'statusOptions' => $this->statusOptions(),
            'formAction' => '/berita',
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
            return redirect('/berita/create');
        }

        $input['desa_id'] = $this->desaId;
        $this->berita->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Berita berhasil dibuat.');
        return redirect('/berita');
    }

    public function show(): mixed
    {
        $berita = $this->findOrRedirect();
        if (!$berita) {
            return redirect('/berita');
        }

        return view('berita/show', [
            'title' => 'Detail Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Berita', 'url' => '/berita'],
                ['label' => $berita['judul']],
            ],
            'berita' => $berita,
        ]);
    }

    public function edit(): mixed
    {
        $berita = $this->findOrRedirect();
        if (!$berita) {
            return redirect('/berita');
        }

        return view('berita/edit', [
            'title' => 'Ubah Berita',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Berita', 'url' => '/berita'],
                ['label' => 'Ubah'],
            ],
            'berita' => $berita,
            'kategoriOptions' => $this->kategori->options($this->desaId),
            'statusOptions' => $this->statusOptions(),
            'formAction' => '/berita/' . $berita['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $berita = $this->findOrRedirect();
        if (!$berita) {
            return redirect('/berita');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input, $berita['id']);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/berita/' . $berita['id'] . '/edit');
        }

        $input['desa_id'] = $this->desaId;
        $input['diperbarui_pada'] = date('Y-m-d H:i:s');

        $this->berita->updateWithSlug($berita['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Berita berhasil diperbarui.');
        return redirect('/berita');
    }

    public function destroy(): mixed
    {
        $berita = $this->findOrRedirect();
        if (!$berita) {
            return redirect('/berita');
        }

        $this->berita->delete($berita['id']);

        session()->flash('success', 'Berita berhasil dihapus.');
        return redirect('/berita');
    }

    protected function prepareInput(): array
    {
        $dipublikasikan = trim((string) $this->request->input('dipublikasikan_pada', ''));

        return [
            'kategori_id' => (int) $this->request->input('kategori_id', 0) ?: null,
            'judul' => trim((string) $this->request->input('judul', '')),
            'ringkasan' => trim((string) $this->request->input('ringkasan', '')),
            'isi' => trim((string) $this->request->input('isi', '')),
            'gambar_sampul' => trim((string) $this->request->input('gambar_sampul', '')),
            'nama_penulis' => trim((string) $this->request->input('nama_penulis', '')),
            'status' => $this->sanitizeStatus($this->request->input('status', 'draf'), 'draf'),
            'unggulan' => (int) (bool) $this->request->input('unggulan', false),
            'dipublikasikan_pada' => $dipublikasikan !== '' ? $dipublikasikan : null,
        ];
    }

    protected function validate(array &$data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['judul'] === '') {
            $errors[] = 'Judul wajib diisi.';
        }

        if ($data['isi'] === '') {
            $errors[] = 'Isi berita wajib diisi.';
        }

        if ($data['kategori_id']) {
            $kategori = $this->kategori->findForDesa($data['kategori_id'], $this->desaId);
            if (!$kategori) {
                $errors[] = 'Kategori tidak valid.';
                $data['kategori_id'] = null;
            }
        }

        if ($data['dipublikasikan_pada']) {
            $timestamp = strtotime($data['dipublikasikan_pada']);
            if ($timestamp === false) {
                $errors[] = 'Tanggal publikasi tidak valid.';
                $data['dipublikasikan_pada'] = null;
            } else {
                $data['dipublikasikan_pada'] = date('Y-m-d H:i:s', $timestamp);
            }
        }

        return $errors;
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data berita tidak ditemukan.');
            return null;
        }

        $berita = $this->berita->findForDesa($id, $this->desaId);

        if (!$berita) {
            session()->flash('error', 'Data berita tidak ditemukan.');
            return null;
        }

        return $berita;
    }

    protected function defaultData(): array
    {
        return [
            'kategori_id' => null,
            'judul' => '',
            'ringkasan' => '',
            'isi' => '',
            'gambar_sampul' => '',
            'nama_penulis' => '',
            'status' => 'draf',
            'unggulan' => 0,
            'dipublikasikan_pada' => '',
        ];
    }

    protected function statusOptions(): array
    {
        return [
            'draf' => 'Draf',
            'dijadwalkan' => 'Dijadwalkan',
            'diterbitkan' => 'Diterbitkan',
        ];
    }

    protected function sanitizeStatus(mixed $status, string $default = ''): string
    {
        $status = strtolower(trim((string) $status));
        return in_array($status, array_keys($this->statusOptions()), true) ? $status : $default;
    }
}
