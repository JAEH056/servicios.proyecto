<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class TipoUsoModel extends Model
{

    protected $DBGroup = 'laboratorios';
    protected $table      = 'tipo_uso';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre'];


    public function obtenerTiposUso()
    {
        return $this->findAll();
    }
}