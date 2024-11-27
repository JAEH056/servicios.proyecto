<?php
namespace App\Models\Labs;


class HorarioModel extends UserModel{

    protected $table      = 'horario';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_semestre','id_laboratorios'];

}