<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class EspecialidadModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'especialidad';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $primaryKey = 'id';

    protected $allowedFields = ['id_carrera', 'clave', 'nombre'];


    public function obtenerEspecialidad(){
        $sql= <<<EOL
        SELECT 
            especialidad.nombre AS nombre_especialidad
        FROM 
        especialidad;
        EOL;

        $query = $this->db->query($sql);
        $especialidad= $query ->getResultArray();
        return $especialidad;
    
    }

}