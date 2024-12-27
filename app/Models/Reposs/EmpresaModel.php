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
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_creacion';

    // Validation
    protected $validationRules      = [
        'nombre_empresa' => [
            'rules' => 'required|max_length[255]|min_length[4]',
            'errors' => [
                'required' => 'El nombre de la empresa es obligatorio.',
                'max_length' => 'El nombre de la empresa no puede tener más de 255 caracteres',
                'min_length' => 'El nombre de la empresa debe tener al menos 4 caracteres.',
            ],
        ],
        'mision' => [
            'rules' => 'max_length[255]|min_length[8]',
            'errors' => [
                'max_length' => 'La misión no puede tener más de 255 caracteres.',
                'min_length' => 'La misión debe tener al menos 8 caracteres.',
            ],
        ],
        'puesto_titular' => [
            'rules' => 'required|max_length[255]|min_length[8]',
            'errors' => [
                'required' => 'El puesto del titular es un campo obligatorio.',
                'max_length' => 'El puesto titular no puede tener más de 255 caracteres.',
                'min_length' => 'El puesto titular debe tener al menos 8 caracteres.',
            ],
        ],
        'grado_titular' => [
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'El grado titular no puede tener más de 255 caracteres.',
            ],
        ],
        'nombre_titular' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre del titular es un campo obligatorio.',
                'max_length' => 'El nombre del titular no puede tener más de 255 caracteres.',
            ],
        ],
        'apellido1_titular' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => 'El primer apellido del titular es un campo obligatorio.',
                'max_length' => 'El primer apellido del titular no puede tener más de 255 caracteres.',
            ],
        ],
        'apellido2_titular' => [
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'El segundo apellido del titular no puede tener más de 255 caracteres.',
            ],
        ],
        'colonia' => [
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'El nombre de la colonia no puede tener más de 255 caracteres.',
            ],
        ],
        'ciudad' => [
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'El nombre de la ciudad no puede tener más de 255 caracteres.',
            ],
        ],
        'codigo_postal' => [
            'rules' => 'max_length[12]',
            'errors' => [
                'max_length' => 'El codigo postal no puede tener más de 12 caracteres.',
            ],
        ],
        'telefono' => [
            'rules' => 'max_length[10]',
            'errors' => [
                'max_length' => 'El telefono no puede tener más de 10 digitos.',
            ],
        ],
        'celular' => [
            'rules' => 'max_length[10]',
            'errors' => [
                'max_length' => 'El celular no puede tener más de 10 digitos.',
            ],
        ],
        'correo' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El correo electrónico es un campo obligatorio.',
                'email' => 'El correo electrónico no es válido.',
            ],
        ],
        'RFC' => [
            'rules' => 'max_length[13]',
            'errors' => [
                'max_length' => 'El RFC no puede tener mas de 13 caracteres.',
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

    public function getEmpresaByUserId($userId)
    {
        return $this->select('empresa.*, rm.nombre AS Ramo, sc.nombre AS Sector')
                      ->join('reposs.ramo rm', 'empresa.idramo = rm.idramo')
                      ->join('reposs.sector sc', 'sc.idsector = empresa.idsector')
                      ->join('reposs.proyecto py', 'py.idempresa = empresa.idempresa')
                      ->where('py.idresidente', $userId)
                      ->get()
                      ->getRowArray();
    }

    public function getAsesorFromEmpresa($userId){

        return $this->select('py.idresidente, py.nombre_proyecto, empresa.nombre_empresa, ae.*')
                    ->join('reposs.proyecto py', 'empresa.idempresa = py.idempresa', 'left')
                    ->join('reposs.asesor_externo ae', 'empresa.idasesor_externo = ae.idasesor_externo', 'left')
                    ->where('py.idresidente', $userId)
                    ->get()
                    ->getRowArray();
    }
}
