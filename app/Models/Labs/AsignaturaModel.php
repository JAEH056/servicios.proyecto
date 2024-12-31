<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class AsignaturaModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'asignatura';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;


    protected $allowedFields = ['id', 'clave', 'nombre', 'satca'];

    public function obtenerClaveMateria($id_materia): array
    {
        $builder = $this->db->table($this->table)
            ->select('asignatura.clave AS clave_asignatura')
            ->where('asignatura.id', $id_materia);

        $query = $builder->get();
        return $query->getResultArray();
    }
}
