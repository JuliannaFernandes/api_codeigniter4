<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produto';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome_produto',
        'descricao',
        'preco',
        'quantidade',
    ];

    //Validation
    protected $validationRules = [
        'nome_produto' => 'required',
        'descricao' => 'required',
        'preco' => 'required|decimal',
        'quantidade' => 'required|integer',
    ];

    //Validations messages
    protected $validationMessages = [
        'nome_produto' => [
            'required' => 'O campo nome_produto é obrigatório.',
        ],
        'descricao' => [
            'required' => 'O campo descricao é obrigatório.',
        ],
        'preco' => [
            'required' => 'O campo preco é obrigatório.',
            'decimal' => 'O campo preco deve ser um número.',
        ],
        'quantidade' => [
            'required' => 'O campo quantidade é obrigatório.',
            'integer' => 'O campo quantidade deve ser um número.',
        ],
    ];

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}
