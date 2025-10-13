<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\GalleryAlbum;

class GalleryAlbumController extends Controller
{
    protected GalleryAlbum $albums;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->albums = new GalleryAlbum($database);
    }

    public function index(): mixed
    {
        $page = (int) $this->request->input('page', 1);
        $filters = [
            'q' => trim((string) $this->request->input('q', '')),
            'unggulan' => $this->sanitizeUnggulan($this->request->input('unggulan', '')),
        ];

        $pagination = $this->albums->paginate($this->desaId, $page, 10, $filters);

        return view('galeri/albums/index', [
            'title' => 'Album Galeri',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => 'Album'],
            ],
            'pagination' => $pagination,
            'filters' => $filters,
        ]);
    }

    public function create(): mixed
    {
        return view('galeri/albums/create', [
            'title' => 'Tambah Album',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => 'Tambah'],
            ],
            'album' => $this->defaultData(),
            'formAction' => '/galeri/albums',
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
            return redirect('/galeri/albums/create');
        }

        $input['desa_id'] = $this->desaId;
        $this->albums->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Album galeri berhasil ditambahkan.');
        return redirect('/galeri/albums');
    }

    public function show(): mixed
    {
        $album = $this->findOrRedirect();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        return view('galeri/albums/show', [
            'title' => 'Detail Album',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => $album['title']],
            ],
            'album' => $album,
        ]);
    }

    public function edit(): mixed
    {
        $album = $this->findOrRedirect();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        return view('galeri/albums/edit', [
            'title' => 'Ubah Album',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => 'Ubah'],
            ],
            'album' => $album,
            'formAction' => '/galeri/albums/' . $album['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        $album = $this->findOrRedirect();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        $input = $this->prepareInput();
        $errors = $this->validate($input, $album['id']);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/galeri/albums/' . $album['id'] . '/edit');
        }

        $input['desa_id'] = $this->desaId;
        $input['updated_at'] = date('Y-m-d H:i:s');
        $this->albums->updateWithSlug($album['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Album galeri berhasil diperbarui.');
        return redirect('/galeri/albums');
    }

    public function destroy(): mixed
    {
        $album = $this->findOrRedirect();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        $this->albums->delete($album['id']);

        session()->flash('success', 'Album galeri berhasil dihapus.');
        return redirect('/galeri/albums');
    }

    protected function prepareInput(): array
    {
        $published = trim((string) $this->request->input('published_at', ''));

        return [
            'title' => trim((string) $this->request->input('title', '')),
            'description' => trim((string) $this->request->input('description', '')),
            'cover_image_url' => trim((string) $this->request->input('cover_image_url', '')),
            'is_featured' => (int) (bool) $this->request->input('is_featured', false),
            'published_at' => $published !== '' ? $published : null,
        ];
    }

    protected function validate(array &$data, int|string|null $id = null): array
    {
        $errors = [];

        if ($data['title'] === '') {
            $errors[] = 'Judul album wajib diisi.';
        }

        if ($data['published_at']) {
            $timestamp = strtotime($data['published_at']);
            if ($timestamp === false) {
                $errors[] = 'Tanggal publikasi tidak valid.';
                $data['published_at'] = null;
            } else {
                $data['published_at'] = date('Y-m-d H:i:s', $timestamp);
            }
        }

        return $errors;
    }

    protected function findOrRedirect(): ?array
    {
        $id = $this->request->route('id');
        if ($id === null) {
            session()->flash('error', 'Data album tidak ditemukan.');
            return null;
        }

        $album = $this->albums->findForDesa($id, $this->desaId);

        if (!$album) {
            session()->flash('error', 'Data album tidak ditemukan.');
            return null;
        }

        return $album;
    }

    protected function defaultData(): array
    {
        return [
            'title' => '',
            'description' => '',
            'cover_image_url' => '',
            'is_featured' => 0,
            'published_at' => '',
        ];
    }

    protected function sanitizeUnggulan(mixed $value): string
    {
        $value = trim((string) $value);
        return in_array($value, ['0', '1'], true) ? $value : '';
    }
}
