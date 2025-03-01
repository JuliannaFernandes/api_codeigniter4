<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class RegistroController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $rules = [
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[usuario.email]'],
            'senha' => ['rules' => 'required|min_length[8]|max_length[255]'],
            'confirmar_senha' => ['label' => 'confirm password', 'rules' => 'matches[password]'],
        ];

        if (!$this->validate($rules)) {
            $model = new \App\Models\UsuarioModel();
            $data = [
                'email' => $this->request->getVar('email'),
                'senha' => password_hash($this->request->getVar('senha'), PASSWORD_DEFAULT),
            ];
            $model->save($data);

            return $this->respondCreated(['message' => 'Usuário cadastrado com sucesso']);
        } else {
            $response = [
                'message' => 'Erro ao cadastrar usuário',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->fail($response, 409);
        }
    }
}
