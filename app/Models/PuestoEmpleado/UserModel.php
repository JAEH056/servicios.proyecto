<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['principal_name', 'nombre', 'apellido1', 'apellido2', ];

    public function findByCorreo($correo) {
        $datosusuarios= $this->where('principal_name', $correo)->first();
        return $datosusuarios;
       

    }
   
}
