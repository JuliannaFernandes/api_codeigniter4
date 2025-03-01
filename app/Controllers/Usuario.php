<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class Usuario extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $usuarios = new \App\Models\UsuarioModel();
        return $this->respond([
            'usuarios' => $usuarios->findAll()
        ], 200);
    }
}
