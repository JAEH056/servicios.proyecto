<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class TipoDiaInhabilModel extends Model
{

    protected $DBGroup = 'laboratorios';
    protected $table      = 'tipo_dia_inhabil';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre'];


    public function obtenerTiposInhabiles()
    {
        return $this->findAll();
    }
}
