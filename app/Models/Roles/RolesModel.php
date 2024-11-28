<?php

namespace App\Models\Roles;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = 'users_roles'; // Table name
    protected $primaryKey = 'ID'; // Primary key, though it might not be required here
    protected $allowedFields = ['ID', 'Lft', 'Rght', 'Title', 'Description']; // Fields we are working with

    // Funcion para solo consultar los roles
    public function getRoles()
    {
    // Se ejecuta la consulta con el builder (usando la tabla del modelo)
    $builder = $this->builder();
    $builder->select('ID, Title, Description');
    // Execute the query and return the result as an array
    return $builder->get()->getResultArray(); // or getResultArray() if you prefer an array
    }
}