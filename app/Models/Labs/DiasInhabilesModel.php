<?php
namespace App\Models\Labs;


class DiasInhabilesModel extends UserModel{

    protected $table      = 'dias_inhabiles';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_tipo_inhabil','descripcion','inicio','fin'];

    public function listarDiasInhabiles(){
     $sql = <<<EOL
    SELECT  
        dias_inhabiles.id as id,
        dias_inhabiles.descripcion as nombre,
        tipo_dia_inhabil.nombre as tipo_inhabil,
        dias_inhabiles.inicio as inicio,
        dias_inhabiles.fin as fin

    FROM 
        dias_inhabiles
    JOIN   
        tipo_dia_inhabil ON  tipo_dia_inhabil.id= dias_inhabiles.id_tipo_inhabil
    GROUP BY
        id,
        inicio, 
        fin

    ORDER BY 
        inicio ASC
    EOL;

    $query = $this->db->query($sql);
    $dias_inhabiles= $query->getResultArray();
    return $dias_inhabiles;
    }

}