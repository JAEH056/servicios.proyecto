<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class AsesorInternoModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'asesor_interno';
    protected $primaryKey       = 'idasesor_interno';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idpuesto',
        'cargo',
        'nombre',
        'apellido1',
        'apellido2',
        'principal_name',
        'telefono'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'idpuesto' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El puesto del asesor es un campo obligatorio.'
            ],
        ],
        'cargo' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El grado academico del asesor es un campo obligatorio.',
                'max_length' => 'El grado del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'nombre' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre del asesor es un campo obligatorio.',
                'max_length' => 'El nombre del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'apellido1' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El primer apellido del asesor es un campo obligatorio.',
                'max_length' => 'El primer apellido del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'apellido2' => [
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'El segundo apellido del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'principal_name' => [
            'rules' => 'valid_email',
            'errors' => [
                'email' => 'El correo electrónico no es válido.',
            ],
        ],
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
