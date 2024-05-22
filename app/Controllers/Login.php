<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UsersModel;
use Firebase\JWT\JWT;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //tela de login
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function login()
    {

        $model = new UsersModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $is_email = $model->where('email', $email)->first();

        if ($is_email) {
            $verifPassword = password_verify($password, $is_email['password']);
            if ($verifPassword) {
                $key = '71562974cb3965dbc5102a73e6d84dd5';
                $name = $is_email['name'];
                $payload = [
                    'iss' => 'localhost',
                    'aud' => 'localhost',
                    //
                    'data' => [
                        'id' => $is_email['id'],
                        'email' => $is_email['email'],
                        'password' => $is_email['password'],
                    ]
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                return $this->respondCreated([
                    'status' => 201,
                    'jwt' => $jwt,
                    'name' => $name,
                    'error' => false,
                    'messages' => [
                        'success' => 'Usuário logado com sucesso'
                    ]
                ]);
            } else {
                return $this->failNotFound("Email ou senha incorretos");
            }
        } else {
            return $this->failNotFound("Email ou senha incorretos");
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
}
