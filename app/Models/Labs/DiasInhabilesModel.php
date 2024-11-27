<?php
namespace App\Models\Labs;


class DiasInhabilesModel extends UserModel{

    protected $table      = 'dias_inhbiles';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombre','inicio','fin','id_tipo_inhabil'];

}