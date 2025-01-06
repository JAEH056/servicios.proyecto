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

    /**
     *  Se busca el documento por tipo y ID del residente
     *  @param int $idResidente
     *  @param string $nombre
     *  @return array
     */
    public function getDocumentByTipo(string $nombre, int $idResidente)
    {
        $this->table('documento');
        return $this->select('documento.iddocumento, documento.archivo, ta.nombre')
            ->join('tipo_archivo ta', 'ta.idtipo = documento.idtipo')
            ->join('pre_requisito preq', 'documento.iddocumento = preq.iddocumento')
            ->groupStart()
            ->where('ta.nombre', $nombre)
            ->where('preq.idresidente', $idResidente)
            ->groupEnd()
            ->first();
    }

    public function obtenerEstadoDocumento(int $userId)
    {
        $this->table('documento');
        return $this->select('documento.iddocumento, documento.archivo,ta.idtipo, ta.nombre, pr.idresidente, val.estado, val.fecha_entrega')
            ->join('reposs.pre_requisito pr', 'documento.iddocumento = pr.iddocumento')
            ->join('reposs.tipo_archivo ta', 'ta.idtipo = documento.idtipo')
            ->join('reposs.validacion val', 'val.iddocumento = documento.iddocumento')
            ->where('pr.idresidente', $userId)
            ->orderBy('val.fecha_entrega', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function obtenerDocumentosParaValidar($numeroControl)
    {
        $builder = $this->db->table('reposs.pre_requisito');

        $builder->select([
            'res.idresidente',
            'res.numero_control',
            'res.principal_name',
            'res.nombre AS requisito',
            'res.apellido1',
            'res.apellido2',
            'doc.iddocumento',
            'doc.archivo',
            'ta.idtipo',
            'ta.nombre AS tipo_archivo_nombre',
            'val.idvalidacion',
            'val.estado',
            'val.observaciones',
            'val.fecha_entrega',
            'val.fecha_actualizacion'
        ]);

        // Joins con las demás tablas
        $builder->join('reposs.residente res', 'pre_requisito.idresidente = res.idresidente', 'left');
        $builder->join('reposs.documento doc', 'pre_requisito.iddocumento = doc.iddocumento', 'left');
        $builder->join('reposs.tipo_archivo ta', 'doc.idtipo = ta.idtipo', 'left');
        $builder->join('reposs.validacion val', 'val.iddocumento = doc.iddocumento', 'left');
        $builder->where('res.numero_control', $numeroControl);

        // Ejecutar la consulta y retornar los resultados
        return $builder->get()->getResultArray();
    }
}
