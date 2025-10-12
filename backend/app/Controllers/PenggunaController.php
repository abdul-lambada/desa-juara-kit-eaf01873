<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    protected Pengguna $pengguna;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->pengguna = new Pengguna($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'q' => trim((string) $this->request->input('q', '')),
            'status' => $this->sanitizeStatus($this->request->input('status', '')),
        ];

        $pagination = $this->pengguna->paginate($page, 10, $filters);

        return view('pengguna/index', [
            'title' => 'Pengguna',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengguna'],
            ],
            'pagination' => $pagination,
            'filters' => $filters,
        ]);
    }

    public function create(): mixed
    {
        return view('pengguna/create', [
            'title' => 'Tambah Pengguna',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengguna', 'url' => '/pengguna'],
                ['label' => 'Tambah'],
            ],
            'pengguna' => [
                'nama' => '',
                'email' => '',
                'telepon' => '',
                'status' => 'aktif',
                'foto_profil' => '',
            ],
            'formAction' => '/pengguna',
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
            return redirect('/pengguna/create');
        }

        $data = $input;
        $data['status'] = $data['status'] ?: 'aktif';

        $this->pengguna->insert([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'status' => $data['status'],
            'foto_profil' => $data['foto_profil'],
        ]);

        session()->setOldInput([]);
        session()->flash('success', 'Pengguna berhasil ditambahkan.');
        return redirect('/pengguna');
    }

    public function show(): mixed
    {
        $pengguna = $this->findOrRedirect();
        if (!$pengguna) {
            return redirect('/pengguna');
        }

        return view('pengguna/show', [
            'title' => 'Detail Pengguna',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengguna', 'url' => '/pengguna'],
                ['label' => $pengguna['nama']],
            ],
            'pengguna' => $pengguna,
        ]);
    }

    public function edit(): mixed
    {
        $pengguna = $this->findOrRedirect();
        if (!$pengguna) {
            return redirect('/pengguna');
        }

        return view('pengguna/edit', [
            'title' => 'Ubah Pengguna',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Pengguna', 'url' => '/pengguna'],
                ['label' => 'Ubah'],
            ],
            'pengguna' => $pengguna,
            'formAction' => '/pengguna/' . $pengguna['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $pengguna = $this->findOrRedirect();
        if (!$pengguna) {
            return redirect('/pengguna');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input, $pengguna['id']);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/pengguna/' . $pengguna['id'] . '/edit');
        }

        $updateData = $input;
        $updateData['diperbarui_pada'] = date('Y-m-d H:i:s');

        $this->pengguna->update($pengguna['id'], $updateData);

        session()->setOldInput([]);
        session()->flash('success', 'Pengguna berhasil diperbarui.');
        return redirect('/pengguna');
    }

    public function destroy(): mixed
    {
        $pengguna = $this->findOrRedirect();
        if (!$pengguna) {
            return redirect('/pengguna');
        }

        $this->pengguna->delete($pengguna['id']);

        session()->flash('success', 'Pengguna berhasil dihapus.');
        return redirect('/pengguna');
    }

    protected function prepareInput(): array
    {
        return [
            'nama' => trim((string) $this->request->input('nama', '')),
            'email' => strtolower(trim((string) $this->request->input('email', ''))),
            'telepon' => trim((string) $this->request->input('telepon', '')),
            'status' => $this->sanitizeStatus($this->request->input('status', 'aktif')),
            'foto_profil' => trim((string) $this->request->input('foto_profil', '')),
        ];
    }

    protected function validate(array $data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['nama'] === '') {
            $errors[] = 'Nama wajib diisi.';
        }

        if ($data['email'] === '') {
            $errors[] = 'Email wajib diisi.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }

        if ($data['email'] !== '') {
            $existing = $this->pengguna->findByEmail($data['email'], $id);
            if ($existing) {
                $errors[] = 'Email sudah digunakan.';
            }
        }

        return $errors;
    }

    protected function sanitizeStatus(mixed $status): string
    {
        $status = strtolower(trim((string) $status));
        return in_array($status, ['aktif', 'nonaktif', 'diblokir'], true) ? $status : 'aktif';
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data pengguna tidak ditemukan.');
            return null;
        }

        $pengguna = $this->pengguna->find($id);

        if (!$pengguna) {
            session()->flash('error', 'Data pengguna tidak ditemukan.');
            return null;
        }

        return $pengguna;
    }
}
