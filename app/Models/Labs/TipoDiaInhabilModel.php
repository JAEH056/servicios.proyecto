<?php
namespace App\Models\Labs;


class TipoDiaInhabilModel extends UserModel{

    protected $table      = 'tipo_dia_inhabil';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombre'];

}