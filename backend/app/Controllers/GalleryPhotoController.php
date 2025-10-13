<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;

class GalleryPhotoController extends Controller
{
    protected GalleryPhoto $photos;
    protected GalleryAlbum $albums;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->photos = new GalleryPhoto($database);
        $this->albums = new GalleryAlbum($database);
    }

    public function index(): mixed
    {
        $album = $this->resolveAlbum();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        $page = (int) $this->request->input('page', 1);
        $pagination = $this->photos->paginate($album['id'], $page, 12);

        return view('galeri/photos/index', [
            'title' => 'Foto Album',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => $album['title'], 'url' => '/galeri/albums/' . $album['id']],
                ['label' => 'Foto'],
            ],
            'album' => $album,
            'pagination' => $pagination,
        ]);
    }

    public function create(): mixed
    {
        $album = $this->resolveAlbum();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        return view('galeri/photos/create', [
            'title' => 'Tambah Foto',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => $album['title'], 'url' => '/galeri/albums/' . $album['id']],
                ['label' => 'Foto', 'url' => '/galeri/albums/' . $album['id'] . '/photos'],
                ['label' => 'Tambah'],
            ],
            'album' => $album,
            'photo' => $this->defaultData($album['id']),
            'formAction' => '/galeri/albums/' . $album['id'] . '/photos',
            'formMethod' => 'POST',
            'submitLabel' => 'Simpan',
        ]);
    }

    public function store(): mixed
    {
        $album = $this->resolveAlbum();
        if (!$album) {
            return redirect('/galeri/albums');
        }

        $input = $this->prepareInput($album['id']);
        $errors = $this->validate($input);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/galeri/albums/' . $album['id'] . '/photos/create');
        }

        $this->photos->create($input);

        session()->setOldInput([]);
        session()->flash('success', 'Foto berhasil ditambahkan.');
        return redirect('/galeri/albums/' . $album['id'] . '/photos');
    }

    public function edit(): mixed
    {
        [$album, $photo] = $this->resolvePhoto();
        if (!$album || !$photo) {
            return redirect('/galeri/albums');
        }

        return view('galeri/photos/edit', [
            'title' => 'Ubah Foto',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
                ['label' => 'Galeri', 'url' => '/galeri/albums'],
                ['label' => $album['title'], 'url' => '/galeri/albums/' . $album['id']],
                ['label' => 'Foto', 'url' => '/galeri/albums/' . $album['id'] . '/photos'],
                ['label' => 'Ubah'],
            ],
            'album' => $album,
            'photo' => $photo,
            'formAction' => '/galeri/albums/' . $album['id'] . '/photos/' . $photo['id'],
            'formMethod' => 'PUT',
            'submitLabel' => 'Perbarui',
        ]);
    }

    public function update(): mixed
    {
        [$album, $photo] = $this->resolvePhoto();
        if (!$album || !$photo) {
            return redirect('/galeri/albums');
        }

        $input = $this->prepareInput($album['id']);
        $errors = $this->validate($input);

        if (!empty($errors)) {
            session()->setOldInput($input);
            session()->flash('error', implode(' ', $errors));
            return redirect('/galeri/albums/' . $album['id'] . '/photos/' . $photo['id'] . '/edit');
        }

        $input['updated_at'] = date('Y-m-d H:i:s');
        $this->photos->updatePhoto($photo['id'], $input);

        session()->setOldInput([]);
        session()->flash('success', 'Foto berhasil diperbarui.');
        return redirect('/galeri/albums/' . $album['id'] . '/photos');
    }

    public function destroy(): mixed
    {
        [$album, $photo] = $this->resolvePhoto();
        if (!$album || !$photo) {
            return redirect('/galeri/albums');
        }

        $this->photos->delete($photo['id']);

        session()->flash('success', 'Foto berhasil dihapus.');
        return redirect('/galeri/albums/' . $album['id'] . '/photos');
    }

    protected function resolveAlbum(): ?array
    {
        $albumId = $this->request->route('album');
        if ($albumId === null) {
            session()->flash('error', 'Album tidak ditemukan.');
            return null;
        }

        $album = $this->albums->findForDesa($albumId, $this->desaId);

        if (!$album) {
            session()->flash('error', 'Album tidak ditemukan.');
            return null;
        }

        return $album;
    }

    protected function resolvePhoto(): array
    {
        $album = $this->resolveAlbum();
        if (!$album) {
            return [null, null];
        }

        $photoId = $this->request->route('id');
        if ($photoId === null) {
            session()->flash('error', 'Foto tidak ditemukan.');
            return [$album, null];
        }

        $photo = $this->photos->findForAlbum($photoId, $album['id']);
        if (!$photo) {
            session()->flash('error', 'Foto tidak ditemukan.');
            return [$album, null];
        }

        return [$album, $photo];
    }

    protected function prepareInput(int $albumId): array
    {
        return [
            'album_id' => $albumId,
            'title' => trim((string) $this->request->input('title', '')),
            'description' => trim((string) $this->request->input('description', '')),
            'image_url' => trim((string) $this->request->input('image_url', '')),
            'display_order' => (int) $this->request->input('display_order', 1),
        ];
    }

    protected function validate(array &$data): array
    {
        $errors = [];

        if ($data['title'] === '') {
            $errors[] = 'Judul foto wajib diisi.';
        }

        if ($data['image_url'] === '') {
            $errors[] = 'URL foto wajib diisi.';
        }

        if ($data['display_order'] < 1) {
            $data['display_order'] = 1;
        }

        return $errors;
    }

    protected function defaultData(int $albumId): array
    {
        return [
            'album_id' => $albumId,
            'title' => '',
            'description' => '',
            'image_url' => '',
            'display_order' => 1,
        ];
    }

    protected function sanitizeUnggulan(mixed $value): string
    {
        $value = trim((string) $value);
        return in_array($value, ['0', '1'], true) ? $value : '';
    }
}
