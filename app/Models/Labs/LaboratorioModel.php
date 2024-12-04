<?php

namespace App\Models\Labs;


class LaboratorioModel extends UserModel
{

    protected $table      = 'laboratorio';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Labs\Laboratorio::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_carrera', 'nombre'];

    public function obtenerLaboratorios()
    {


        $sql = <<<EOL
        SELECT 
            laboratorio.id AS id,
            carrera.id AS carrera_id,
            carrera.nombre AS carrera_nombre,
            laboratorio.nombre AS nombre_laboratorio
        FROM 
            laboratorio
        JOIN carrera ON carrera.id = laboratorio.id_carrera
        GROUP BY laboratorio.id
        EOL;

       $query = $this->db->query($sql);
       $laboratorios = $query->getResultArray();
       return $laboratorios;

    }


}
