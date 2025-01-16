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
        'principal_name',
        'puesto',
        'grado_academico',
        'nombre',
        'apellido1',
        'apellido2',
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
        'principal_name' => [
            'rules' => 'valid_email',
            'errors' => [
                'email' => 'El correo electrónico no es válido.',
            ],
        ],
        'puesto' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El puesto del asesor es un campo requerido.',
                'max_length' => 'El puesto del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'grado_academico' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El grado academico del asesor es un campo requerido.',
                'max_length' => 'El grado academico del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'nombre' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre del asesor es un campo requerido.',
                'max_length' => 'El nombre del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'apellido1' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El primer apellido del asesor es un campo requerido.',
                'max_length' => 'El primer apellido del asesor no puede tener más de 255 caracteres.',
            ],
        ],
        'apellido2' => [
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'El segundo apellido del asesor no puede tener más de 255 caracteres.',
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

    /**
     *  Actualiza el ID Asesor Interno usando como parametros
     *  de referencia el ID de Residente e ID del proyecto.
     */
    public function updateAsesorInternoByIdResidente($data, $userId, $idProyecto)
    {
        $this->transStart();
        // Step 1: Insertar el nuevo asesor interno 
        if ($this->insert($data) == false) {
            // Si el insert falla, rollback y regresa un false
            $this->transRollback();
            return [
                'success' => false,
                'message' => 'Fallo al insertar el asesor Interno.'
            ];
        }
        // Obtener el ID generado del asesor externo 
        $idAsesorInterno = $this->insertID();
        // Paso 2: Actualizar el idasesor_interno en la tabla proyecto
        $builder = $this->db->table('reposs.proyecto');
        $builder->set('proyecto.idasesor_interno', $idAsesorInterno)
                ->where('proyecto.idproyecto', $idProyecto)
                ->where('proyecto.idresidente', $userId);
        if ($builder->update() == false) {
            $this->transRollback();
            return [
                'success' => false,
                'message' => 'Fallo al actualizar el proyecto con el nuevo asesor interno.'
            ];
        }
        $this->transComplete();
        if ($this->transStatus() === false) {
            // Transaccion fallida
            return [
                'success' => false,
                'message' => 'Transaccion fallida durante la actualizacion de datos.'
            ];
        }
        // Transaccion exitosa
        return [
            'success' => true,
            'message' => 'Asesor Interno actualizado correctamente.'
        ];
    }
}
