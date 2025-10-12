<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Models\Pengguna;

class HomeController extends Controller
{
    protected Pengguna $pengguna;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->pengguna = new Pengguna($database);
    }

    public function index(): mixed
    {
        $jumlahPengguna = count($this->pengguna->all(['id']));

        return view('home/index', [
            'title' => 'Dasbor',
            'breadcrumbs' => [
                ['label' => 'Dasbor', 'url' => '/'],
            ],
            'statistik' => [
                'pengguna' => $jumlahPengguna,
            ],
        ]);
    }
}
