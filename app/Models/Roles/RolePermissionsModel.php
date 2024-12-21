<?php

namespace App\Models\Roles;

use CodeIgniter\Model;

class RolePermissionsModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'phpRbca_rolepermissions'; // Nombre de la tabla
    protected $primaryKey = 'RoleID'; // Llave primaria, quiza no sea necesaria aqui...
    protected $allowedFields = ['RoleID', 'PermissionID', 'AssignmentDate']; // Campoos con los que se pueden trabajar.

    public function getRolePermissions()
    {
        /* Se contruye la consulta usando Query Builder 
        *
        *  La consulta obtiene los datos de Permisos y Roles
        *  usando la tabla de users_rolepermissions(rbca) como intermediaria
        *
        */
        $builder = $this->builder();
        $builder = $this->db->table('phpRbca_rolepermissions rp');
        $builder->select('rp.RoleID, r.Title AS RoleName, rp.PermissionID, p.Description AS PermissionName, rp.AssignmentDate')
            ->join('users_roles r', 'rp.RoleID = r.ID')
            ->join('users_permissions p', 'rp.PermissionID = p.ID');
        // Ejecuta la consulta y devuelve los resultados
        return $builder->get()->getResultArray(); /// o getRowArray() si solo se usa un registro
    }
    public function getRolePermissionsByRoleID($RoleID){
        /* Se contruye la consulta usando Query Builder 
        *
        *  Se conulta el ID del Permiso usando como filtro el ID del rol
        *  el cual se recive al citar la funcion con el modelo
        *  como resultado manda solo un ID (ROW/Fila) en caso de que el Rol ID tenga mas de un Permiso.
        *
        */
        $builder = $this->builder();
        $builder->select('PermissionID')
                ->where('RoleID', $RoleID);
        return $builder->get()->getRowArray();  /// Se obtiene el resultado de una sola fila en caso de haber mas de una.
    }
}
