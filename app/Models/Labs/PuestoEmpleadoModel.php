<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class PuestoEmpleadoModel extends Model
{

    protected $DBGroup = 'laboratorios';
    protected $table      = 'puesto_empleado';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'id_organigrama', 'inicia', 'termina'];
}
