<?php

namespace App\Models\Roles;

use CodeIgniter\Model;

class PermissionsModel extends Model
{
    protected $table = 'users_permissions'; // Table name
    protected $primaryKey = 'ID'; // Primary key, though it might not be required here
    protected $allowedFields = ['ID', 'Lft', 'Rght', 'Title', 'Description']; // Fields we are working with

    //Funcion para consultar titulo y descripcion de la tabla permisos(rbca)
    public function getPermissions()
    {
        // Ejecuta la consulta con builder (usando la tabla del modelo)
        $builder = $this->builder();
        $builder->select('ID, Title, Description');
        // Ejecuta la consulta y devuelve los resultados
        return $builder->get()->getResultArray(); /// o getRowArray() si solo se usa un registro
    }
    // Funcion para consultar el nombre (Title) de permiso usando el ID (del permiso)
    public function getPermissionsById($id){
        $builder = $this->builder();
        $builder->select('Title')->where('ID',$id);
        return $builder->get()->getRowArray();
    }
}