<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class ReticulaModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'reticula';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;


    protected $allowedFields = ['id_carrera', 'id_especialidad', 'id_asignatura'];

    public function obtenerReticula($id_carrera): array
    {
        $builder = $this->db->table($this->table)
            ->select('asignatura.id AS id,
                  asignatura.nombre AS nombre_asignatura')
            ->join('asignatura', 'asignatura.id = reticula.id_asignatura')
            ->join('carrera', 'carrera.id = reticula.id_carrera')
            ->where('carrera.id', $id_carrera)
            ->orderBy('asignatura.nombre', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
