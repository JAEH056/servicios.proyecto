<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class LoginUserModel extends Model
{
    protected $DBGroup          = "residentes"; // database group
    protected $table            = 'usuario';  // Nombre de la tabla
    protected $primaryKey       = 'idusuario'; // Clave primaria de la tabla
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['correo', 'nombre', 'apellido1', 'apellido2']; // Campos que se pueden insertar

    // Otros métodos que puedas necesitar, por ejemplo, validaciones.
    public function insertData($data) {
        // Your existing insert logic
        return $this->insert($data);
    }
    public function findByCorreo($correo) {
        // Use the getWhere method to find a record by the 'correo' field
        return $this->where('correo', $correo)->first();
    }
}