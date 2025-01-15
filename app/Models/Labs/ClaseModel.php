<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class ClaseModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'clase';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';


    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_carrera',
        'id_asignatura',
        'id_grupo'
    ];

   

    public function insertarClase($dataClase)
    {
        $this->db->transStart();

        $this->insert($dataClase);


        if ($this->db->transStatus() === false) {

            $this->db->transRollback();
            return false;
        }

        $this->db->transComplete();

        return $this->getInsertID();
    }
}
