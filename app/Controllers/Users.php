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
    public function indexCreate()
    {
        helper(['form']);
        $rules = [
            'name' => 'required',
            'age' => 'required'
        ];
        $data = [
            'name' => $this->request->getVar('name'),
            'age' => $this->request->getVar('age')
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UsersModel();
        $model->save($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data Inserted'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}