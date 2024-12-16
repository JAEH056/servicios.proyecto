<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class DocumentoModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'documento';
    protected $primaryKey       = 'iddocumento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['iddocumento', 'archivo', 'idtipo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_entrega';
    protected $updatedField  = 'fecha_actualizacion';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Obtener el archivo actual
    public function getCurrentDocument()
    {
        return $this->first();  // Devuelve el primer (y único) documento
    }

    public function getDocumentByTipo(string $nombre)
    {
        $this->table('documento');
        return $this->select('documento.iddocumento, documento.archivo')
            ->join('tipo_archivo', 'tipo_archivo.idtipo = documento.idtipo')
            ->where('tipo_archivo.nombre', $nombre)
            ->first();
    }
}
