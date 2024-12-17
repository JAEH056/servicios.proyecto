<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'empresa';
    protected $primaryKey       = 'idempresa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idempresa', 
        'nombre_empresa', 
        'mision', 
        'puesto_titular', 
        'grado_titular', 
        'nombre_titular', 
        'apellido1_titular', 
        'apellido2_titular', 
        'colonia', 
        'ciudad', 
        'codigo_postal', 
        'telefono', 
        'celular', 
        'correo', 
        'RFC', 
        'idramo', 
        'idsector', 
        'idasesor_externo', 
        'fecha_creacion'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_creacion';

    // Validation
    protected $validationRules      = [];
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
