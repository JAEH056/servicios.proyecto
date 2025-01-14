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
    protected $validationRules      = [
        'numero_control'    => 'required',
        'nombre'            => 'required|max_length[255]',
        'apellido1'         => 'required|max_length[255]',
        'apellido2'         => 'max_length[255]',
        'domicilio'         => 'max_length[255]',
        'ciudad'            => 'max_length[255]',
        'seguro_social'     => 'required',
        'numero_ss'         => 'required',
        'celular'           => 'min_length[10]'
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

    /*
    *   IMPORTANTE: esta funcion es utilizada en el modelo Usuarios
    *   con el mismo nombre (parte IMPORTANTE del proceso OAUTH).
    *   Eliminar o modificar esta funcion puede afectar la autenticacion.
    */
    public function esPrimerIngreso(string $correo): bool
    {
        return empty($this->where('principal_name', $correo)->first());
    }

    /**
     *  Funcion para actualizar los datos del usuario (residente)
     *  Verifica que los datos sean los mismos que en la BD.
     */
    public function actualizarNombreUsuario(array $nombreCompleto, int $idResidente): array
    {
        // Obtener el usuario actual de la base de datos
        $usuario = $this->find($idResidente);

        // Si no se encuentra el usuario, retornar false
        if (!$usuario || empty($usuario)) {
            return [
                'success' => false,
                'mensaje' => 'No se encontro el usuario'
            ];
        }

        // Separar los apellidos
        $apellidos = $this->splitSurname($nombreCompleto['surname']);

        // Verificar si los datos coinciden
        if (
            $usuario['nombre'] === $nombreCompleto['givenName'] &&
            $usuario['apellido1'] === $apellidos['apellido1'] &&
            $usuario['apellido2'] === $apellidos['apellido2']
        ) {
            return [
                'success' => true,
                'mensaje' => 'No es necesario actualizar'
            ];
        }

        // Actualizar los datos del usuario
        $data = [
            'nombre'    => $nombreCompleto['givenName'],
            'apellido1' => $apellidos['apellido1'],
            'apellido2' => $apellidos['apellido2'],
        ];
        // se actualizan los datos
        if (!$this->update($idResidente, $data)) {
            return [
                'success' => false,
                'mensaje' => 'Error al actualizar nombre de usuario'
            ];
        }
        return [
            'success' => true,
            'mensaje' => 'Datos actualizados correctamente'
        ];
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
    /**
     * Muestra los datos del alumno y su carrera y modalidad
     * @return mixed
     */
    public function residentesInfoList()
    {
        return $this->select('numero_control, nombre, apellido1, apellido2, pe.nombre_programa_educativo')
            ->join('reposs.programa_educativo pe', 'residente.idprograma_educativo = pe.idprograma_educativo')
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
            'aint.principal_name AS correo_asesor_interno'
        ]);

        // Join con las tablas relacionadas
        $builder->join('reposs.programa_educativo pe', 'residente.idprograma_educativo = pe.idprograma_educativo');
        $builder->join('reposs.modalidad mo', 'pe.idmodalidad = mo.idmodalidad');
        $builder->join('reposs.proyecto py', 'residente.idresidente = py.idresidente', 'left');
        $builder->join('reposs.empresa emp', 'py.idempresa = emp.idempresa', 'left');
        $builder->join('reposs.sector sec', 'emp.idsector = sec.idsector', 'left');
        $builder->join('reposs.ramo ro', 'emp.idramo = ro.idramo', 'left');
        $builder->join('reposs.asesor_externo aex', 'emp.idasesor_externo = aex.idasesor_externo', 'left');
        $builder->join('reposs.asesor_interno aint', 'py.idasesor_interno = aint.idasesor_interno', 'left');

        // Condición WHERE
        $builder->where('residente.numero_control', $numeroControl);

        // Generar y ejecutar la consulta
        $query = $builder->get();   /// Se ejecuta la consulta
        return $query->getRowArray(); /// Se espera una sola fila
    }

    public function splitSurname(string $fullSurname): array
    {
        // Usa explode() para romper la cadena en piezas separadas por espacios.
        $parts = explode(" ", $fullSurname);
        // Se revisa si tiene mas de una palabra (to ensure it's a full name).
        if (count($parts) > 1) {
            // Se separa la ultima palabra como segundo apellido.
            $familySurname = array_pop($parts);
            // Se unen las palabras restantes como el primer apellido.
            $prefixOrFirstSurname = implode(" ", $parts);
            // Se regresan las dos partes en un arreglo.
            return [
                'apellido1' => $prefixOrFirstSurname,
                'apellido2' => $familySurname
            ];
        } else {
            // Si no hay un espacio se regresa la cadena original.
            return [
                'apellido1' => $fullSurname,
                'apellido2' => ''
            ];
        }
    }
}
