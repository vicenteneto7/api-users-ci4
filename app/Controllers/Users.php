<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Users extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function listUser()
    {
        $model = new UsersModel();
        $data = $model->findAll();

        $request = service('request');
        $key = '71562974cb3965dbc5102a73e6d84dd5';
        $headers = $request->getHeader('authorization');
        $jwt = $headers->getValue();
        $userData = JWT::decode($jwt, new Key($key, 'HS256'));
        return $this->respond([
            'status' => 200,
                'error' => false,
                'messages' => [
                    'sucess' => 'Lista encontrada'
                ],
                'users' => $data
        ]);

        
       

       

    }

    

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */

    public function create()
    {

        $model = new UsersModel();

        helper(['form']);
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
            'name' => 'required',
        ];
        $data = [
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getVar('name')
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());


        //Validação de e-mail duplicado

        $is_email = $model->where('email', $this->request->getVar('email'))->first();
        if ($is_email) {
            return $this->respond([
                'status' => 404,
                'error' => true,
                'messages' => [
                    'error' => 'Esse email já existe na base de dados'
                ]
            ]);
        } else {
            $model->save($data);
            $response = [
                'data' => $data,
                'status' => 201,
                'error' => false,
                'messages' => [
                    'success' => 'Usuário criado'
                ]
            ];
            return $this->respondCreated($response);
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */

    public function update($id = null)
    {
        helper(['form']);
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
            'name' => 'required',

        ];
        $data = [
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getVar('name')
        ];

        $request = service('request');
        $key = '71562974cb3965dbc5102a73e6d84dd5';
        $headers = $request->getHeader('authorization');
        $jwt = $headers->getValue();
        $userData = JWT::decode($jwt, new Key($key, 'HS256'));

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UsersModel();
        $findById = $model->find(['id' => $id]);
        if (!$findById) return $this->failNotFound('Usuário não encontrado');
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Informações atualizadas'
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new UsersModel();

        $request = service('request');
        $key = '71562974cb3965dbc5102a73e6d84dd5';
        $headers = $request->getHeader('authorization');
        $jwt = $headers->getValue();
        $userData = JWT::decode($jwt, new Key($key, 'HS256'));

        $model->where('id', $id)->delete();

        if (!$id) return $this->failNotFound('Usuário não encontrado');
        $model->delete($id);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Usuário deletado'
            ]
        ];
        return $this->respond($response);
    }
    
}
