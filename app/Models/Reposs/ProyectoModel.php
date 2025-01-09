<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'proyecto';
    protected $primaryKey       = 'idproyecto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idproyecto', 
        'nombre_proyecto', 
        'banco_proyecto', 
        'idresidente', 
        'idempresa', 
        'idasesor_interno', 
        'fecha_inicio', 
        'fecha_fin'
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

    /**
     *  Obtener las empresas disponibles para cada residnete (las que creo en caso de haber mas de una)
     */
    public function getProyectoEmpresasByUserId($userId)
    {
        return $this->select('proyecto.idproyecto, proyecto.nombre_proyecto, emp.idempresa, emp.nombre_empresa')
                      ->join('reposs.empresa emp', 'proyecto.idempresa = emp.idempresa')
                      ->where('proyecto.idresidente', $userId)
                      ->get()
                      ->getResultArray();
    }
}
