<?php
namespace App\Models\Labs;


class SemestreModel extends UserModel{

    protected $table      = 'semestre';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombre','inicio','fin'];

}