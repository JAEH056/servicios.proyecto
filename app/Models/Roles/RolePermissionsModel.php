<?php

namespace App\Models\Roles;

use CodeIgniter\Model;

class RolePermissionsModel extends Model
{
    protected $table = 'users_rolepermissions'; // Table name
    protected $primaryKey = 'RoleID'; // Primary key, though it might not be required here
    protected $allowedFields = ['RoleID', 'PermissionID', 'AssignmentDate']; // Fields we are working with

    public function getRolePermissions()
    {
        /* Se contruye la consulta usando Query Builder 
        *
        *  La consulta consulta los datos de Permisos y Roles
        *  usando la tabla de users_rolepermissions como intermediaria
        *
        */
        $builder = $this->builder();
        $builder = $this->db->table('users_rolepermissions rp');
        $builder->select('rp.RoleID, r.Description AS RoleName, rp.PermissionID, p.Description AS PermissionName, rp.AssignmentDate')
            ->join('users_roles r', 'rp.RoleID = r.ID')
            ->join('users_permissions p', 'rp.PermissionID = p.ID');

        // Execute the query and return the result
        return $builder->get()->getResultArray(); // or getResultArray() if you prefer an array
    }
}
