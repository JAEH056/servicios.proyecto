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
        // Se ejecuta la consulta con el builder usando la tabla roles(rbca)
        $builder = $this->builder();
        $builder->select('ID, Title, Description');
        // Ejecuta la consulta y devuelve los resultados como Array
        return $builder->get()->getResultArray(); /// o getRowArray() si solo se usa un registro
    }

    // Funcion para eliminar un rol (Usando el ID como referencia)
    public function deleteRole($roleId)
    {
        $builder = $this->builder();
        $builder->where('ID', $roleId)
            ->delete();
        //Para una ejecusion exitosa no se devuelven valores (AJAX entra en conflicto al recibir una respuesta)
    }

    // Funcion para buscar roles de usuario (usando su ID)
    public function getRolesUser($userId)
    {
        $builder = $this->builder();
        $builder->select('Title') /// Solo se selecciona el campo Titulo
            ->where('ID', $userId);
        return $builder->get()->getResultArray(); ///Importante el obtener el resultado en array para mejor manejo
    }
}