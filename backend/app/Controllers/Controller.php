<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;

abstract class Controller
{
    protected Request $request;
    protected Database $db;
    protected int $desaId;

    public function __construct(Request $request, Database $database)
    {
        $this->request = $request;
        $this->db = $database;
        $this->desaId = (int) config('app.desa_id', 1);
    }
}
