<?php

    namespace App\Models\Labs;

use CodeIgniter\Model;

    class CarreraModel extends Model
    {
        protected $DBGroup = 'laboratorios';
        protected $table      = 'carrera';
        protected $primaryKey = 'id';

        protected $useAutoIncrement = true;

        protected $returnType     =  \App\Entities\Labs\Carrera::class;
        protected $useSoftDeletes = false;

        protected $allowedFields = ['clave', 'nombre','nombre_corto'];

        public function obtenerCarrera()
        {
            $sql = <<<EOL
            SELECT 
                carrera.id AS id,
                carrera.nombre AS nombre_carrera,
                carrera.nombre_corto AS nombre_corto
            FROM carrera
            EOL;

            $query = $this->db->query($sql);
            $carrera = $query->getResultArray();
            return $carrera;
        }
    }
