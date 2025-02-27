<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'cliente';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome_razao_social',
        'cpf_cnpj',
    ];

    // Validation
    protected $validationRules    = [
        'nome_razao_social' => 'required',
        'cpf_cnpj' => 'required|is_unique[cliente.cpf_cnpj]',
    ];

    //Validation messages
    protected $validationMessages = [
        'nome_razao_social' => [
            'required' => 'O campo nome_razão_social é obrigatório',
        ],
        'cpf_cnpj' => [
            'required' => 'O campo cpf_cnpj é obrigatório',
            'is_unique' => 'O campo cpf_cnpj deve ser único',
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

}