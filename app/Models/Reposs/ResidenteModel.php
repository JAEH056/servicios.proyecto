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
        return empty($this->where('principal_name', $correo)->first());
    }
    public function findByCorreo2($correo)
    {
        return $this->where('principal_name', $correo)->first();
    }
    public function findByCorreo($userId)
    {
        return $this->select('residente.*, pe.idprograma_educativo, pe.nombre_programa_educativo, mo.nombre_modalidad')
            ->join('reposs.programa_educativo pe', 'residente.idprograma_educativo = pe.idprograma_educativo')
            ->join('reposs.modalidad mo', 'pe.idmodalidad = mo.idmodalidad')
            ->where('residente.idresidente', $userId)
            ->first();
    }
    public function residentesInfoList()
    {
        return $this->select('numero_control, nombre, apellido1, apellido2, pe.nombre_programa_educativo, nombre_proyecto, nombre_empresa, p.fecha_inicio, p.fecha_fin')
            ->join('reposs.programa_educativo pe', 'residente.idprograma_educativo = pe.idprograma_educativo')
            ->join('reposs.proyecto p', 'residente.idresidente = p.idresidente', 'left')
            ->join('reposs.empresa e', 'p.idempresa = e.idempresa', 'left')
            ->orderBy('residente.idresidente', 'asc')
            ->get()
            ->getResultArray();
    }
    public function residentesInfoListByNumeroControl($numeroControl)
    {
        $builder = $this->table('reposs.residente');
        $builder->select([
            'residente.idresidente',
            'residente.principal_name',
            'residente.numero_control',
            'residente.nombre',
            'residente.apellido1',
            'residente.apellido2',
            'residente.domicilio',
            'residente.ciudad',
            'residente.seguro_social',
            'residente.numero_ss',
            'residente.telefono',
            'residente.celular',
            'pe.nombre_programa_educativo',
            'mo.nombre_modalidad',
            'py.nombre_proyecto',
            'py.banco_proyecto',
            'py.fecha_inicio',
            'py.fecha_fin',
            'emp.idempresa',
            'emp.nombre_empresa',
            'emp.mision',
            'emp.puesto_titular',
            'emp.grado_titular',
            'emp.nombre_titular',
            'emp.apellido1_titular',
            'emp.apellido2_titular',
            'emp.colonia',
            'emp.ciudad',
            'emp.codigo_postal',
            'emp.telefono',
            'emp.celular',
            'emp.correo',
            'emp.RFC',
            'emp.fecha_creacion',
            'sec.nombre AS sector',
            'ro.nombre AS ramo',
            'aex.nombre AS nombre_asesor_externo',
            'aex.correo AS correo_asesor_externo',
            'aint.nombre AS nombre_asesor_interno',
            'aint.correo AS correo_asesor_interno'
        ]);

        // Join con las tablas relacionadas
        $builder->join('reposs.programa_educativo pe', 'residente.idprograma_educativo = pe.idprograma_educativo');
        $builder->join('reposs.modalidad mo', 'pe.idmodalidad = mo.idmodalidad');
        $builder->join('reposs.proyecto py', 'residente.idresidente = py.idresidente', 'left');
        $builder->join('reposs.empresa emp', 'py.idempresa = emp.idempresa', 'left');
        $builder->join('reposs.sector sec', 'emp.idsector = sec.idsector');
        $builder->join('reposs.ramo ro', 'emp.idramo = ro.idramo');
        $builder->join('reposs.asesor_externo aex', 'emp.idasesor_externo = aex.idasesor_externo', 'left');
        $builder->join('reposs.asesor_interno aint', 'py.idasesor_interno = aint.idasesor_interno', 'left');

        // Condición WHERE
        $builder->where('residente.numero_control', $numeroControl);

        // Generar y ejecutar la consulta
        $query = $builder->get();   /// Se ejecuta la consulta
        return $query->getRowArray(); /// Se espera una sola fila
    }
}
