<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class ReticuladModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'reticula';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;


    protected $allowedFields = ['id_carrera', 'id_especialidad', 'id_asignatura'];


    public function obtenerEspecialidad($id_carrera)
    {
        $sql = <<<EOL
        SELECT

            asignatura.nombre AS asignatura,
            especialidad.nombre  AS especialidad
            carrera.nombre As carrera

        FROM reticula
             join especialidad on reticula.id_especialidad= especialidad.id
            left join especialidad on especialidad.id = reticula.id_especialidad
            join asignatura on  asignatura.id= reticula.id_asignatura
            join carrera on carrera.id = reticula.id_carrera
            where carrera.id='$id_carrera'


       
    
        EOL;
    }
}
