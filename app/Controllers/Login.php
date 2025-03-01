<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new \App\Models\UsuarioModel();

        $email = $this->request->getVar('email');
        $senha = $this->request->getVar('senha');

        $usuario = $model->where('email', $email)->first();

        if (is_null($usuario)) {
            {
                return $this->respond(['error' => 'Usuario ou senha inválidos.'], 401);
            }
        }
        $verificaSenha = password_verify($senha, $usuario['senha']);

        if (!$verificaSenha) {
            return $this->respond(['error' => 'Usuario ou senha inválidos.'], 401);
        }
        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat,
            "exp" => $exp,
            "email" => $usuario['email'],
        );

        $token = JWT::encode($payload, $key, 'HS256');

        $response = [
            'message' => 'Login efetuado com sucesso',
            'token' => $token,
        ];

        return $this->respond($response, 200);
    }
}
