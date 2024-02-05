<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new UsersModel();
        $data = $model->findAll();
        return $this->respond($data);
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
            return $this->respondCreated([
                'status' => 404,
                'error' => true,
                'messages' => [
                    'fail' => 'Esse email já existe'
                ]
            ]);
        } else {
            $model->save($data);
            $response = [
                'data' => $data,
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Data Inserted'
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
            'password' => $this->request->getVar('password'),
            'name' => $this->request->getVar('name')
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UsersModel();
        $findById = $model->find(['id' => $id]);
        if (!$findById) return $this->failNotFound('No Data Found');
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Updated'
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
        $model->where('id', $id)->delete();

        if (!$id) return $this->failNotFound('No Data Found');
        $model->delete($id);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];
        return $this->respond($response);
    }
}
