<?php

    namespace App\Models\Labs;

use CodeIgniter\Model;

    class CarreraModel extends Model
    {
        protected $DBGroup = 'laboratorios';
        protected $table      = 'carrera';
        protected $primaryKey = 'id';

        protected $useAutoIncrement = true;

        protected $returnType   = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['clave', 'nombre','nombre_corto'];

        public function obtenerCarrera():array
        {
            $builder = $this->db->table($this->table)
            ->select('carrera.id AS id,
                      carrera.clave AS clave_carrera,
                      carrera.nombre AS nombre_carrera,
                      carrera.nombre_corto AS nombre_corto');
                      $query = $builder->get();
                      $carrera = $query->getResultArray();
                      return $carrera;
            // $sql = <<<EOL
            // SELECT 
            //     carrera.id AS id,
            //     carrera.clave AS clave_carrera,
            //     carrera.nombre AS nombre_carrera,
            //     carrera.nombre_corto AS nombre_corto
            //     From carrera
           
            // EOL;

            // $query = $this->db->query($sql);
            // $carrera = $query->getResultArray();
            // return $carrera;
        }
    }
