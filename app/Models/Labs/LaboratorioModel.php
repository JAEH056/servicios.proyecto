<?php

namespace App\Models\Labs;


class LaboratorioModel extends UserModel
{

    protected $table      = 'laboratorio';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Labs\laboratorios::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_carrera', 'nombre'];

    protected $validationRules =[
        'nombre' => 'requiered|max_length[255]|min_length[30]'
    ];

    
    public function obtenerLaboratorios()
    {


        $sql = <<<EOL
        SELECT 
            laboratorio.nombre as laboratorio,
            carrera.nombre as carrera
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
       $laboratorios = $query->getResultArray();
      // print_r($laboratorios);
       return $laboratorios;
     
       

    }

    public function actualizarLaboratorios( $datosLaboratorio){
        return $this->insert($datosLaboratorio);
    
    }
}
