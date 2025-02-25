<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PedidoController extends ResourceController
{
    protected $modelName = 'App\Models\Pedido';
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
            'data_pedido' => $this->model->orderBy('id', 'DESC')->findAll(),
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
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
        ]);

        if (!$rules) {
            $response = [
                'message' => 'Erro ao cadastrar pedido',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($response, 400);
        }

        $produtoModel = new \App\Models\Produto();
        $produto = $produtoModel->find($this->request->getVar('produto_id'));

        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        if ($produto['quantidade'] < $this->request->getVar('quantidade')) {
            return $this->fail('Quantidade indisponível');
        }

        $quantidade = $this->request->getVar('quantidade');
        $valor_total = $produto['preco'] * $quantidade;

        $produtoModel->update($produto['id'], [
            'quantidade' => $produto['quantidade'] - $quantidade,
        ]);

        $this->model->insert([
            'cliente_id' => esc($this->request->getVar('cliente_id')),
            'produto_id' => esc($this->request->getVar('produto_id')),
            'quantidade' => esc($this->request->getVar('quantidade')),
            'valor_total' => esc($valor_total),
            'status' => 'em aberto',
        ]);

        $response = [
            'message' => 'Pedido cadastrado com sucesso',
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
        //
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
