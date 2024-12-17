<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class OrganigramaModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'usuario';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['correo', 'nombre', 'apellido1', 'apellido2'];
}
