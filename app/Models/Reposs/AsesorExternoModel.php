<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class AsesorExternoModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'asesor_externo';
    protected $primaryKey       = 'idasesor_externo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idasesor_externo',
        'puesto',
        'grado',
        'nombre',
        'apellido1',
        'apellido2',
        'correo',
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
        'puesto' => [
            'rules' => 'required|max_length[255]|min_length[8]',
            'errors' => [
                'required' => 'El puesto del asesor es un campo obligatorio.',
                'max_length' => 'El puesto asesor no puede tener más de 255 caracteres.',
                'min_length' => 'El puesto asesor debe tener al menos 8 caracteres.',
            ],
        ],
        'grado' => [
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
        'correo' => [
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

    public function updateAsesorExternoByIdResidente($data, $userId)
    {
        $this->transStart();
        // Step 1: Insertar el nuevo asesor externo 
        if (!$this->insert($data)) {
            // Si el insert falla, rollback y regresa un false
            $this->transRollback();
            return [
                'success' => false,
                'message' => 'Fallo al insertar el asesor externo.'
            ];
        }
        // Obtener el ID generado del asesor externo 
        $idAsesorExterno = $this->insertID();
        // Paso 2: Actualizar el idasesor_externo en la tabla empresa
        $subQuery = $this->db->table('reposs.proyecto')
            ->select('proyecto.idempresa')
            ->where('proyecto.idresidente', $userId);
        $builder = $this->db->table('reposs.empresa');
        $builder->set('idasesor_externo', $idAsesorExterno)
                ->whereIn('empresa.idempresa', $subQuery) // Usar subconsulta directamente
                ->update();
        $this->transComplete();
        if ($this->transStatus() === false) {
            // Transaction failed
            return [
                'success' => false,
                'message' => 'Transaccion fallida durante la actualizacion de datos.'
            ];
        } 
        // Transaction successful
        return [
            'success' => true,
            'message' => 'Asesor Externo actualizado correctamente.'
        ];
    }

    public function asesorExternoByUserId($userId){
        $this->db->table('reposs.empresa emp');
        $this->select('py.idresidente,py.nombre_proyecto, emp.nombre_empresa, ae.*')
             ->join('reposs.proyecto py', 'emp.idempresa = py.idempresa', 'left')
             ->join('reposs.asesor_externo ae', 'emp.idasesor_externo = ae.idasesor_externo', 'left')
             ->where('py.idresidente', $userId)
             ->get()
             ->getResult();
    }
}
