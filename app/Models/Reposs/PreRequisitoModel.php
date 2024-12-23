<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class PreRequisitoModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'pre_requisito';
    protected $primaryKey       = 'idpre_requisito';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idpre_requisito',
        'idresidente',
        'iddocumento',
        'nombre_pre_requisito'
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

    public function getRequestById(int $idresidente, int $idtipo)
    {
        $this->table('reposs.pre_requisito');
        return $this->select('documento.iddocumento, documento.archivo')
                    ->join('reposs.documento', 'pre_requisito.iddocumento = documento.iddocumento')
                    ->where('pre_requisito.idresidente', $idresidente)
                    ->where('documento.idtipo', $idtipo)
                    ->get()
                    ->getResultArray();
    }
}
