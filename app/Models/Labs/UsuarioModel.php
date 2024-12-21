<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table      = 'usuario';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['principal_name', 'nombre', 'apellido1', 'apellido2'];
}
