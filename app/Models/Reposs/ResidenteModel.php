<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class ResidenteModel extends Model
{
    protected $DBGroup          = 'residentes'; // database group
    protected $table            = 'residente';
    protected $primaryKey       = 'idresidente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idresidente',
        'idprograma_educativo',
        'principal_name',
        'numero_control',
        'nombre', 
        'apellido1', 
        'apellido2', 
        'domicilio',  
        'ciudad', 
        'seguro_social', 
        'numero_ss', 
        'telefono', 
        'celular'
    ];

    protected array $casts = [];
    protected array $castHandlers = [];

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
    
    /*
    *   IMPORTANTE: esta funcion es utilizada en el modelo Usuarios
    *   con el mismo nombre (parte IMPORTANTE del proceso OAUTH).
    *   Eliminar o modificar esta funcion puede afectar la autenticacion.
    */
    public function esPrimerIngreso(string $correo): bool
    {
        return empty($this->where('principal_name',$correo)->first());
    }
    public function findByCorreo2($correo) {
        return $this->where('principal_name', $correo)->first();
    }
    public function findByCorreo($userId) {
        return $this->select('residente.*, pe.idprograma_educativo, pe.nombre_programa_educativo, mo.nombre_modalidad')
                    ->join('reposs.programa_educativo pe', 'residente.idprograma_educativo = pe.idprograma_educativo')
                    ->join('reposs.modalidad mo', 'pe.idmodalidad = mo.idmodalidad')
                    ->where('residente.idresidente', $userId)
                    ->first();
    }
}
