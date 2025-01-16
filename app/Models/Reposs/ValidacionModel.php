<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class ValidacionModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'validacion';
    protected $primaryKey       = 'idvalidacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idvalidacion',
        'estado',
        'observaciones',
        'idpuesto',
        'iddocumento'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_entrega';
    protected $updatedField  = 'fecha_actualizacion';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'estado'        => 'required|max_length[255]',
        'observaciones' => 'max_length[255]',
        'iddocumento'   => 'required',
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

    public function getDocumentByTipo(int $iddocumento)
    {
        $this->table('validacion');
        return $this->delete('iddocumento', $iddocumento);
    }
}
