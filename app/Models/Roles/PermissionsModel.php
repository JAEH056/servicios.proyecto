<?php

namespace App\Models\Roles;

use CodeIgniter\Model;

class PermissionsModel extends Model
{
    protected $table = 'users_permissions'; // Table name
    protected $primaryKey = 'ID'; // Primary key, though it might not be required here
    protected $allowedFields = ['ID', 'Lft', 'Rght', 'Title', 'Description']; // Fields we are working with

    //Funcion para consultar titulo y descripcion de la tabla permisos
    public function getPermissions()
    {
        // Ejecuta la consulta con builder (usando la tabla del modelo)
        $builder = $this->builder();
        $builder->select('ID, Title, Description');
        // Execute the query and return the result
        return $builder->get()->getResultArray(); // or getResultArray() if you prefer an array
    }
}