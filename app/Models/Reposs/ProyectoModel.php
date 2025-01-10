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

    /**
     *  Lista de proyectos con informacion de empresa y asesores
     */
    public function getListaProyectos()
    {
        $builder = $this->db->table('proyecto');
        $builder->select([
            'proyecto.idproyecto',
            'proyecto.nombre_proyecto',
            'proyecto.banco_proyecto',
            'proyecto.fecha_inicio',
            'proyecto.fecha_fin',
            'res.idresidente',
            'res.principal_name',
            'res.numero_control',
            'res.nombre',
            'res.apellido1',
            'res.apellido2',
            'aint.idpuesto',
            'aint.puesto',
            'aint.principal_name',
            'aint.grado_academico',
            'aint.nombre',
            'aint.apellido1',
            'aint.apellido2',
            'emp.nombre_empresa',
            'rm.nombre AS ramo',
            'sec.nombre AS sector',
            'emp.puesto_titular',
            'emp.grado_titular',
            'emp.nombre_titular',
            'emp.apellido1_titular',
            'emp.apellido1_titular',
            'aext.puesto',
            'aext.grado',
            'aext.nombre',
            'aext.apellido1',
            'aext.apellido2'
        ]);
        $builder->join('reposs.residente res ',' proyecto.idresidente = res.idresidente')
            ->join('asesor_interno aint', 'proyecto.idasesor_interno = aint.idasesor_interno', 'left')
            ->join('empresa emp', 'proyecto.idempresa = emp.idempresa', 'left')
            ->join('asesor_externo aext', 'emp.idasesor_externo = aext.idasesor_externo', 'left')
            ->join('ramo rm', 'emp.idramo = rm.idramo')
            ->join('sector sec', 'emp.idsector = sec.idsector')
            ->where('proyecto.nombre_proyecto is not null');

        return $builder->get()->getResultArray();
    }

    public function getProyectoByNumeroControl($numeroControl)
    {
        $builder = $this->db->table('proyecto');
        $builder->select([
            'proyecto.idproyecto',
            'proyecto.nombre_proyecto',
            'proyecto.banco_proyecto',
            'proyecto.fecha_inicio',
            'proyecto.fecha_fin',
            'res.idresidente',
            'res.principal_name',
            'res.numero_control',
            'res.nombre',
            'res.apellido1',
            'res.apellido2',
            'aint.idpuesto',
            'aint.puesto AS puesto_aint',
            'aint.principal_name AS principal_name_aint',
            'aint.grado_academico',
            'aint.nombre AS nombre_aint',
            'aint.apellido1 AS apellido1_aint',
            'aint.apellido2 AS apellido2_aint',
            'emp.nombre_empresa',
            'rm.nombre AS ramo',
            'sec.nombre AS sector',
            'emp.puesto_titular',
            'emp.grado_titular',
            'emp.nombre_titular',
            'emp.apellido1_titular',
            'emp.apellido1_titular',
            'aext.puesto AS puesto_aext',
            'aext.grado AS grado_aext',
            'aext.nombre AS nombre_aext',
            'aext.apellido1 AS apellido1_aext',
            'aext.apellido2 AS apellido2_aext'
        ]);
        $builder->join('reposs.residente res ',' proyecto.idresidente = res.idresidente')
            ->join('asesor_interno aint', 'proyecto.idasesor_interno = aint.idasesor_interno', 'left')
            ->join('empresa emp', 'proyecto.idempresa = emp.idempresa', 'left')
            ->join('asesor_externo aext', 'emp.idasesor_externo = aext.idasesor_externo', 'left')
            ->join('ramo rm', 'emp.idramo = rm.idramo')
            ->join('sector sec', 'emp.idsector = sec.idsector')
            ->where('proyecto.nombre_proyecto is not null')
            ->where('res.numero_control', $numeroControl);

        return $builder->get()->getResultArray();
    }
}
