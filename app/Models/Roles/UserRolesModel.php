<?php

namespace App\Models\Roles;

use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Model;

class UserRolesModel extends Model
{
    protected $table = 'users_userroles'; // Table name
    protected $primaryKey = 'UserID'; // Primary key, though it might not be required here
    protected $allowedFields = ['UserID', 'RoleID', 'AssignmentDate']; // Fields we are working with

    /**
     * Funcion para solo consultar los roles
     *
     * @return array
     * @param int $userId
     */
    public function getUserRolesById(int $userId): ResultInterface|array
    {
        // Se ejecuta la consulta con el builder (usando la tabla del modelo)
        $builder = $this->builder();
        $builder->select('RoleID')
            ->where('UserID', $userId);
        // Ejecuta la consulta y devuelve los resultados como Array
        return $builder->get()->getResultArray(); /// or getResultArray() if you prefer an array
    }
    /**
     * Funcion para eliminar el rol de un usuario
     *
     * @param int $roleId
     * @return bool add if is needed
     */
    public function deleteRoleByUserId(int $roleId): void
    {
        $builder = $this->builder();
        $builder->where('ID', $roleId)
            ->delete();
        // return $builder->delete(); // Return success status if is needed
        //Para una ejecución exitosa no se devuelven valores (AJAX entra en conflicto al recibir una respuesta)
    }
    /**
     * Funcion para buscar TODOS los ROLES de UN usuario
     *
     * @param int $userId
     * @return array
     */
    public function getRolesByUserId(int $userId): array
    {
        $builder = $this->builder();
        $builder->where('ID', $userId);
        // Ejecuta la consulta y devuelve los resultados como Array
        return $builder->get()->getResultArray(); /// Retorna un arreglo con todos los roles del $userId
    }

    public function getUserNRoles()
    {
        $builder = $this->builder();
        $builder->select('UserID, RoleID');
        // Ejecuta la consulta y devuelve los resultados como Array
        return $builder->get()->getResultArray(); /// Retorna un arreglo con todos los roles del $
    }

    //Asignar rol a usuario
    public function setRoleToUser(int $role, int $userId)
    {
        $data = [
            'RoleID'            => $role,
            'UserID'            => $userId,
            'AssignmentDate'    => time(),
        ];
        $builder = $this->builder();
        $builder->insert($data);
        /*/Manejo de errores en la consulta
        if () {
            return true;  // Si la inserción es exitosa, retorna el ID de la nueva fila
        } else {
            // Si la inserción falla, puedes retornar un error o false
            return false;
        }*/
    }
}
