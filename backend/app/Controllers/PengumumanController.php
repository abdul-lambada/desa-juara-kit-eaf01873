<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    protected Pengumuman $pengumuman;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->pengumuman = new Pengumuman($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'q' => trim((string) $this->request->input('q', '')),
            'status' => $this->sanitizeStatus($this->request->input('status', ''), ''),
            'prioritas' => $this->sanitizePrioritas($this->request->input('prioritas', ''), ''),
        ];

        $pagination = $this->pengumuman->paginate($this->desaId, $page, 10, $filters);

        return view('pengumuman/index', [
            'title' => 'Pengumuman',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengumuman'],
            ],
            'pagination' => $pagination,
            'filters' => $filters,
            'statusOptions' => $this->statusOptions(),
            'prioritasOptions' => $this->prioritasOptions(),
        ]);
    }

    public function create(): mixed
    {
        return view('pengumuman/create', [
            'title' => 'Tambah Pengumuman',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengumuman', 'url' => '/pengumuman'],
                ['label' => 'Tambah'],
            ],
            'pengumuman' => $this->defaultData(),
            'statusOptions' => $this->statusOptions(),
            'prioritasOptions' => $this->prioritasOptions(),
            'formAction' => '/pengumuman',
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
            return redirect('/pengumuman/create');
        }

        $input['desa_id'] = $this->desaId;
        $this->pengumuman->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Pengumuman berhasil dibuat.');
        return redirect('/pengumuman');
    }

    public function show(): mixed
    {
        $pengumuman = $this->findOrRedirect();
        if (!$pengumuman) {
            return redirect('/pengumuman');
        }

        return view('pengumuman/show', [
            'title' => 'Detail Pengumuman',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengumuman', 'url' => '/pengumuman'],
                ['label' => $pengumuman['judul']],
            ],
            'pengumuman' => $pengumuman,
        ]);
    }

    public function edit(): mixed
    {
        $pengumuman = $this->findOrRedirect();
        if (!$pengumuman) {
            return redirect('/pengumuman');
        }

        return view('pengumuman/edit', [
            'title' => 'Ubah Pengumuman',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengumuman', 'url' => '/pengumuman'],
                ['label' => 'Ubah'],
            ],
            'pengumuman' => $pengumuman,
            'statusOptions' => $this->statusOptions(),
            'prioritasOptions' => $this->prioritasOptions(),
            'formAction' => '/pengumuman/' . $pengumuman['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $pengumuman = $this->findOrRedirect();
        if (!$pengumuman) {
            return redirect('/pengumuman');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input, $pengumuman['id']);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/pengumuman/' . $pengumuman['id'] . '/edit');
        }

        $input['desa_id'] = $this->desaId;
        $input['diperbarui_pada'] = date('Y-m-d H:i:s');

        $this->pengumuman->updateWithSlug($pengumuman['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Pengumuman berhasil diperbarui.');
        return redirect('/pengumuman');
    }

    public function destroy(): mixed
    {
        $pengumuman = $this->findOrRedirect();
        if (!$pengumuman) {
            return redirect('/pengumuman');
        }

        $this->pengumuman->delete($pengumuman['id']);

        session()->flash('success', 'Pengumuman berhasil dihapus.');
        return redirect('/pengumuman');
    }

    protected function prepareInput(): array
    {
        $dipublikasikan = trim((string) $this->request->input('dipublikasikan_pada', ''));
        $berakhir = trim((string) $this->request->input('berakhir_pada', ''));

        return [
            'judul' => trim((string) $this->request->input('judul', '')),
            'isi' => trim((string) $this->request->input('isi', '')),
            'prioritas' => $this->sanitizePrioritas($this->request->input('prioritas', 'sedang'), 'sedang'),
            'status' => $this->sanitizeStatus($this->request->input('status', 'dijadwalkan'), 'dijadwalkan'),
            'dipublikasikan_pada' => $dipublikasikan !== '' ? $dipublikasikan : null,
            'berakhir_pada' => $berakhir !== '' ? $berakhir : null,
            'lokasi' => trim((string) $this->request->input('lokasi', '')),
            'kontak_nama' => trim((string) $this->request->input('kontak_nama', '')),
            'kontak_telepon' => trim((string) $this->request->input('kontak_telepon', '')),
        ];
    }

    protected function validate(array &$data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['judul'] === '') {
            $errors[] = 'Judul wajib diisi.';
        }

        if ($data['isi'] === '') {
            $errors[] = 'Isi pengumuman wajib diisi.';
        }

        foreach (['dipublikasikan_pada', 'berakhir_pada'] as $field) {
            if ($data[$field]) {
                $timestamp = strtotime($data[$field]);
                if ($timestamp === false) {
                    $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' tidak valid.';
                    $data[$field] = null;
                } else {
                    $data[$field] = date('Y-m-d H:i:s', $timestamp);
                }
            }
        }

        return $errors;
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data pengumuman tidak ditemukan.');
            return null;
        }

        $pengumuman = $this->pengumuman->findForDesa($id, $this->desaId);

        if (!$pengumuman) {
            session()->flash('error', 'Data pengumuman tidak ditemukan.');
            return null;
        }

        return $pengumuman;
    }

    protected function defaultData(): array
    {
        return [
            'judul' => '',
            'isi' => '',
            'prioritas' => 'sedang',
            'status' => 'dijadwalkan',
            'dipublikasikan_pada' => '',
            'berakhir_pada' => '',
            'lokasi' => '',
            'kontak_nama' => '',
            'kontak_telepon' => '',
        ];
    }

    protected function statusOptions(): array
    {
        return [
            'draf' => 'Draf',
            'dijadwalkan' => 'Dijadwalkan',
            'diterbitkan' => 'Diterbitkan',
            'kedaluwarsa' => 'Kedaluwarsa',
        ];
    }

    protected function prioritasOptions(): array
    {
        return [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
        ];
    }

    protected function sanitizeStatus(mixed $status, string $default = ''): string
    {
        $status = strtolower(trim((string) $status));
        return array_key_exists($status, $this->statusOptions()) ? $status : $default;
    }

    protected function sanitizePrioritas(mixed $prioritas, string $default = ''): string
    {
        $prioritas = strtolower(trim((string) $prioritas));
        return array_key_exists($prioritas, $this->prioritasOptions()) ? $prioritas : $default;
    }
}
