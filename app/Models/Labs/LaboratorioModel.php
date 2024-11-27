<?php

namespace App\Models\Labs;


class LaboratorioModel extends UserModel
{

    protected $table      = 'laboratorio';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_carrera', 'nombre'];

    public function obtenerLaboratorios()
    {


        $sql = <<<EOL
        SELECT 
            laboratorio.nombre,
            carrera.nombre
        FROM 
            laboratorio
        JOIN carrera  ON carrera.id= laboratorio.id_carrera
        GROUP BY
            laboratorio.id,
            carrera.id
        ORDER BY
            laboratorio.id ASC

        EOL;

        $query = $this->db->query($sql);
        $horas = $query->getResultArray();
         
    }
}
