<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class NivelModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'nivel';
    protected $primaryKey = 'idnivel';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre_nivel'];


    public function obtenerNivel()
    {
        return $this->findAll();
    }
}
