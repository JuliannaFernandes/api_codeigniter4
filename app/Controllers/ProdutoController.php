<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProdutoController extends ResourceController
{
    protected $modelName = 'App\Models\Produto';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data_cliente' => $this->model->orderBy('id', 'DESC')->findAll(),
        ];

        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = $this->validate([
            'nome_produto' => 'required',
            'descricao' => 'required',
            'preco' => 'required|decimal',
            'quantidade' => 'required|integer',
        ]);

        if (!$rules) {
            $response = [
                'message' => 'Erro ao cadastrar produto',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($response, 400);
        }
        $this->model->insert([
            'nome_produto' => esc($this->request->getVar('nome_produto')),
            'descricao' => esc($this->request->getVar('descricao')),
            'preco' => esc($this->request->getVar('preco')),
            'quantidade' => esc($this->request->getVar('quantidade')),
        ]);

        $response = [
            'message' => 'Produto cadastrado com sucesso',
            'data' => $this->request->getVar(),
        ];

        return $this->respondCreated($response, 200);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'nome_produto' => 'required',
            'descricao' => 'required',
            'preco' => 'required|decimal',
            'quantidade' => 'required|integer',
        ]);

        if (!$rules) {
            $response = [
                'message' => 'Erro ao atualizar produto',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($response, 400);
        }
        $this->model->update($id, [
            'nome_produto' => esc($this->request->getVar('nome_produto')),
            'descricao' => esc($this->request->getVar('descricao')),
            'preco' => esc($this->request->getVar('preco')),
            'quantidade' => esc($this->request->getVar('quantidade')),
        ]);

        $response = [
            'message' => 'Produto atualizado com sucesso',
        ];

        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
