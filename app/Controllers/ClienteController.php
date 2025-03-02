<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ClienteController extends ResourceController
{
    protected $modelName = 'App\Models\ClienteModel';
    protected $format = 'json';

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
            if (!empty($valor) && $this->model->db->fieldExists($campo, 'cliente')) {
                $query = $query->like($campo, $valor);
            }
        }

        $response = [
            'cabecalho' => [
                'status' => 200,
                'menssagem' => 'Dados retornados com sucesso',
            ],
            'retorno' => [
                'dados_cliente' => $query->paginate(10),
                'pagination' => [
                    'current_page' => $this->model->pager->getCurrentPage(),
                    'page_count' => $this->model->pager->getPageCount(),
                    'total_items' => $this->model->pager->getTotal(),
                    'next' => $this->model->pager->getNextPageURI(),
                    'previous' => $this->model->pager->getPreviousPageURI(),
                ]
            ],
        ];

        return $this->respond($response);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $requestData = $this->request->getJSON(true);

        if (!isset($requestData['parametros']) || !is_array($requestData['parametros'])) {
            return $this->failValidationErrors(['menssagem' => 'Parâmetros inválidos'], 400);
        }

        $data = $requestData['parametros'];

        if (!$this->model->validate($data)) {
            return $this->failValidationErrors([
                'menssagem' => 'Erro ao cadastrar cliente',
                'errors' => $this->model->errors(),
            ], 400);
        }

        $this->model->insert([
            'nome_razao_social' => esc($data['nome_razao_social']),
            'cpf_cnpj' => esc($data['cpf_cnpj']),
        ]);

        $response = [
            'cabecalho' => [
                'status' => 201,
                'menssagem' => 'Cliente cadastrado com sucesso',
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

        if (!isset($requestData['parametros']) || !is_array($requestData['parametros'])) {
            return $this->failValidationErrors(['mensagem' => 'Parâmetros inválidos'], 400);
        }

        $data = $requestData['parametros'];

        if (!$this->model->validate($data)) {
            $response = [
                'mensagem' => 'Erro ao atualizar cliente',
                'errors' => $this->model->errors(),
            ];
            return $this->failValidationErrors($response, 400);
        }

        $this->model->update($id, [
            'nome_razao_social' => esc($data['nome_razao_social']),
            'cpf_cnpj' => esc($data['cpf_cnpj']),
        ]);

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Cliente atualizado com sucesso',
            ],
            'retorno' => $data,
        ];

        return $this->respondDeleted($response);
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
        $pedidoModel = new \App\Models\PedidoModel();
        $pedido = $pedidoModel->where('cliente_id', $id)->countAllResults();

        if ($pedido) {
            return $this->fail('Cliente possui pedidos cadastrados');
        }

        $this->model->delete($id);

        $response = [
            'mensagem' => 'Cliente deletado com sucesso',
        ];

        return $this->respondDeleted($response, 200);
    }
}