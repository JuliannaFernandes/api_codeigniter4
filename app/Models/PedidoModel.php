<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table            = 'pedido';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cliente_id',
        'produto_id',
        'quantidade',
        'valor_total',
        'status',
    ];

    //Validation
    protected $validationRules = [
        'cliente_id' => 'required|integer',
        'produto_id' => 'required|integer',
        'quantidade' => 'required|integer',
    ];

    //Validations messages
    protected $validationMessages = [
        'cliente_id' => [
            'required' => 'O campo cliente_id é obrigatório.',
            'integer' => 'O campo cliente_id deve ser um número.',
        ],
        'produto_id' => [
            'required' => 'O campo produto_id é obrigatório.',
            'integer' => 'O campo produto_id deve ser um número.',
        ],
        'quantidade' => [
            'required' => 'O campo quantidade é obrigatório.',
            'integer' => 'O campo quantidade deve ser um número.',
        ],
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}
