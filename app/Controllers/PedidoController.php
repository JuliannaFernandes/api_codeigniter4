<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\View\Table;

class PedidoController extends ResourceController
{
    protected $modelName = 'App\Models\PedidoModel';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $filters = $this->request->getGet();
        $query = $this->model->orderBy('id', 'DESC');

        foreach ($filters as $campo => $valor) {
            if (!empty($valor) && $this->model->db->fieldExists($campo, 'pedido')) {
                $query = $query->like($campo, $valor);
            }
        }

        $data = [
            'mensagem' => 'success',
            'dados_pedido' => $this->model->orderBy('id', 'DESC')->paginate(10),
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
        $requestData = $this->request->getJSON(true);
        $clienteModel = new \App\Models\ClienteModel();
        $produtoModel = new \App\Models\ProdutoModel();

        if(!isset($requestData['parametros']) || !is_array($requestData['parametros'])) {
            return $this->failValidationErrors(['mensagem' => 'Parâmetros inválidos'], 400);
        }

        $data = $requestData['parametros'];

        if (!$this->model->validate($data)) {
            return $this->failValidationErrors([
                'mensagem' => 'Erro ao cadastrar pedido',
                'errors' => $this->model->errors(),
            ], 400);
        }

        $cliente = $clienteModel->find($data['cliente_id']);
        if (!$cliente) {
            return $this->failNotFound('Cliente não encontrado');
        }

        $produto = $produtoModel->find($data['produto_id']);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        if ($produto['quantidade'] < $data['quantidade']) {
            return $this->fail('Quantidade indisponível');
        }

        $quantidade = $data['quantidade'];
        $valor_total = $produto['preco'] * $quantidade;

        $produtoModel->update($produto['id'], [
            'quantidade' => $produto['quantidade'] - $quantidade,
        ]);

        $this->model->insert([
            'cliente_id' => esc($data['cliente_id']),
            'produto_id' => esc($data['produto_id']),
            'quantidade' => esc($quantidade),
            'valor_total' => esc($valor_total),
            'status' => 'em aberto',
        ]);

        $response = [
            'cabecalho' => [
                'status' => 201,
                'mensagem' => 'Pedido cadastrado com sucesso',
            ],
            'retorno' => [
                $data,
            ],
        ];

        return $this->respondCreated($response);
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
        $requestData = $this->request->getJSON(true);
        $clienteModel = new \App\Models\ClienteModel();
        $produtoModel = new \App\Models\ProdutoModel();

        if (!isset($requestData['parametros']) || !is_array($requestData['parametros'])) {
            return $this->failValidationErrors(['mensagem' => 'Parâmetros inválidos'], 400);
        }

        $data = $requestData['parametros'];

        if (!$this->model->validate($data)) {
            return $this->failValidationErrors([
                'mensagem' => 'Erro ao atualizar pedido',
                'errors' => $this->model->errors(),
            ], 400);
        }

        if ($data['quantidade'] <= 0) {
        return $this->failValidationErrors([
            'mensagem' => 'A quantidade deve ser maior que zero',
        ], 400);
        }

        $cliente = $clienteModel->find($data['cliente_id']);
        if (!$cliente) {
            return $this->failNotFound('Cliente não encontrado');
        }

        $produto = $produtoModel->find($data['produto_id']);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        $pedido = $this->model->find($id);
        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado');
        }

        $statusValidos = ['em aberto', 'pago', 'cancelado'];
        if (isset($data['status']) && !in_array($data['status'], $statusValidos)) {
            return $this->fail('Esse status não está disponível, as opções são: em aberto, pago ou cancelado');
        }

        $originalQuantidade = $pedido['quantidade'];
        $pedidoQuantidade = $data['quantidade'];
        $quantidadeDiferenca = $pedidoQuantidade - $originalQuantidade;

        if ($produto['quantidade'] < $quantidadeDiferenca) {
            return $this->fail('Quantidade indisponível no estoque');
        }

        $produtoModel->update($produto['id'], [
            'quantidade' => $produto['quantidade'] - $quantidadeDiferenca,
        ]);

        $valorTotal = $produto['preco'] * $pedidoQuantidade;

        $this->model->update($id, [
            'cliente_id'  => esc($data['cliente_id']),
            'produto_id'  => esc($data['produto_id']),
            'quantidade'  => esc($pedidoQuantidade),
            'valor_total' => esc($valorTotal),
            'status'      => esc($data['status'] ?? 'em aberto'),
        ]);

        $response = [
            'cabecalho' => [
                'status' => 201,
                'mensagem' => 'Pedido atualizado com sucesso',
            ],
            'retorno' => [
                $data,
            ],
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
        $pedido = $this->model->find($id);

        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado');
        }

        $produtoModel = new \App\Models\ProdutoModel();
        $produto = $produtoModel->find($pedido['produto_id']);

        $produtoModel->update($produto['id'], [
            'quantidade' => $produto['quantidade'] + $pedido['quantidade'],
        ]);

        $this->model->delete($id);

        $response = [
            'mensagem' => 'Pedido deletado com sucesso',
        ];

        return $this->respondDeleted($response);
    }
}
