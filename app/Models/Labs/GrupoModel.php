<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'grupo';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType   = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_carrera', 'nombre'];


    public function obtenerGruposPorCarrera($id_carrera): array
    {

        $builder = $this->db->table($this->table)
            ->select('grupo.id AS id_grupo, grupo.nombre AS nombre_grupo')
            ->join('carrera', 'carrera.id = grupo.id_carrera')
            ->where('carrera.id', $id_carrera)
            ->orderBy('grupo.nombre', 'ASC');


        $query = $builder->get();

        return $query->getResultArray();
    }
}
