<?php

namespace App\Models\Roles;

use CodeIgniter\Model;

class UserRolesModel extends Model
{
    protected $table = 'users_userroles'; // Table name
    protected $primaryKey = 'UserID'; // Primary key, though it might not be required here
    protected $allowedFields = ['UserID', 'RoleID', 'AssignmentDate']; // Fields we are working with

    // Funcion para solo consultar los roles
    public function getRoles()
    {
        // Se ejecuta la consulta con el builder (usando la tabla del modelo)
        $builder = $this->builder();
        $builder->select('RoleID');
        // Ejecuta la consulta y devuelve los resultados como Array
        return $builder->get(); /// or getResultArray() if you prefer an array
    }
    // Funcion para eliminar un rol
    public function deleteRole($roleId)
    {
        $builder = $this->builder();
        $builder->where('ID', $roleId)
            ->delete();
        //Para una ejecusion exitosa no se devuelven valores (AJAX entra en conflicto al recibir una respuesta)
    }
    // Funcion para buscar roles de usuario
    public function getRolesUser($userId)
    {
        $builder = $this->builder();
        $builder->where('ID', $userId);
        // Ejecuta la consulta y devuelve los resultados como Array
        return $builder->get()->getResultArray();
    }
}
