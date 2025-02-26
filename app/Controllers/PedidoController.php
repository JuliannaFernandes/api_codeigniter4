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
            'data_pedido' => $this->model->orderBy('id', 'DESC')->paginate(1),
            'pagination' => [
                'current_page' => $this->model->pager->getCurrentPage(),
                'page_count' => $this->model->pager->getPageCount(),
                'total_items' => $this->model->pager->getTotal(),
                'next' => $this->model->pager->getNextPageURI(),
                'previous' => $this->model->pager->getPreviousPageURI(),
            ]
        ];

        return $this->respond($data);
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
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
        ]);

        if (!$rules) {
            $response = [
                'message' => 'Erro ao atualizar pedido',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($response, 400);
        }

        $produtoModel = new \App\Models\Produto();
        $pedido = $this->model->find($id);
        $produto = $produtoModel->find($this->request->getVar('produto_id'));

        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        $originalQuantidade = $pedido['quantidade'];
        $pedidoQuantidade = $this->request->getVar('quantidade');
        $quantidadeDiferenca = $originalQuantidade - $pedidoQuantidade;

        if ($produto['quantidade'] + $quantidadeDiferenca < 0) {
            return $this->fail('Quantidade indisponível');
        }

        $valor_total = $produto['preco'] * $pedidoQuantidade;

        $produtoModel->update($produto['id'], [
            'quantidade' => $produto['quantidade'] + $quantidadeDiferenca,
        ]);

        $status = $this->request->getVar('status') ?: 'em aberto';

        $this->model->update($id, [
            'cliente_id' => esc($this->request->getVar('cliente_id')),
            'produto_id' => esc($this->request->getVar('produto_id')),
            'quantidade' => esc($pedidoQuantidade),
            'valor_total' => esc($valor_total),
            'status' => esc($status),
        ]);

        $response = [
            'message' => 'Pedido atualizado com sucesso',
        ];

        return $this->respondCreated($response, 200);
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
        $pedido = $this->model->find($id);

        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado');
        }

        $produtoModel = new \App\Models\Produto();
        $produto = $produtoModel->find($pedido['produto_id']);

        $produtoModel->update($produto['id'], [
            'quantidade' => $produto['quantidade'] + $pedido['quantidade'],
        ]);

        $this->model->delete($id);

        $response = [
            'message' => 'Pedido deletado com sucesso',
        ];

        return $this->respondDeleted($response);
    }
}
