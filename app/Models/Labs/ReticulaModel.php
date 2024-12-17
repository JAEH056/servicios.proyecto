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


    public function obtenerReticula($id_carrera)
    {
        $sql = <<<EOL
        SELECT

            asignatura.nombre AS materia,
            asignatura.clave AS clave_materia,
            asignatura.satca AS satca_materia,

            especialidad.nombre  AS especialidad
            carrera.nombre As carrera

        FROM reticula
        LEFT JOIN  especialidad on especialidad.id = reticula.id_especialidad
        join asignatura on  asignatura.id= reticula.id_asignatura
        join carrera on carrera.id = reticula.id_carrera
        where carrera.id='$id_carrera'
        order by asignatura.nombre asc
        
        EOL;
        $query = $this->db->query($sql);
        $reticula= $query->getResultArray();
        print_r($reticula);
        return $reticula;
    }
}
