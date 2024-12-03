<?php
namespace App\Models\Labs;


class SemestreModel extends UserModel{

    protected $table      = 'semestre';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombre','inicio','fin'];

    public function obtenerSemestre(){
        $sql = <<<EOL
        SELECT 
            semestre.nombre as nombre,
            semestre.inicio as inicio,
            semestre.fin as fin
        FROM 
            semestre
        ORDER BY
           inicio ASC
        EOL;
        $query = $this->db->query($sql);
        $semestre= $query->getResultArray();
      
       return $semestre;
    }
}