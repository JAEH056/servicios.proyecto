<?php

namespace App\Controllers\Reposs;

use App\Controllers\BaseController;
use App\Models\Roles\RolePermissionsModel;
use App\Models\Roles\RolesModel;
use App\Models\Roles\PermissionsModel;

class AdminController extends BaseController
{
    protected $rbac;

    public function __construct()
    {
        // Cargar el servicio PHP-RBAC
        $this->rbac = service('rbac');
    }

    // Vista principal del panel de administración
    public function index()
    {
        // Se cargan los modelos de los roles, permisos y asignaciones de permisos
        $roleModel = new RolesModel();
        $permissionModel = new PermissionsModel();
        $rolePermissionModel = new RolePermissionsModel();

        // Se obtiene la consulta de cada uno de los modelos con su respectiva funcion
        $roles['roles'] = $roleModel->getRoles();
        $permissions['permissions'] = $permissionModel->getPermissions();
        $rolePermissions['rolePermissions'] = $rolePermissionModel->getRolePermissions();

        // Se carga la vista del panel con los datos de las consultas
        /*
        *   NOTA: Se cargan los datos como arreglo para una funcion adecuada con AJAX based request
        */
        return view('admin/index', [ 'roles' => $roles['roles'], 'permissions' => $permissions['permissions'], 'rolePermissions' => $rolePermissions['rolePermissions'] ]);
        //return view('admin/index', compact('roles', 'permissions', 'rolePermissions'));
    }

    // Crear un rol
    public function createRole()
    {
        $roleName = $this->request->getPost('role_name');
        $roleDescription = $this->request->getPost('role_description');

        if ($roleName) {
            $this->rbac->Roles->add($roleName, $roleDescription);
            return redirect()->to('/admin')->with('success', 'Rol creado exitosamente');
        }
        return redirect()->to('/admin')->with('error', 'Error al crear el rol');
    }

    // Eliminar un rol
    public function deleteRole()
    {
        if ($this->request->isAJAX()) {
            $roleId = $this->request->getJSON()->role_id;

            if ($roleId) {
                $db = \Config\Database::connect();
                $db->table('users_roles')
                    ->where('ID', $roleId)
                    ->delete();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Role deleted successfully.'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Role ID.'
            ]);
        }
        
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }


    // Crear un permiso
    public function createPermission()
    {
        $permissionName = $this->request->getPost('permission_name');
        $permissionDescription = $this->request->getPost('permission_description');

        if ($permissionName) {
            $this->rbac->Permissions->add($permissionName, $permissionDescription);
            return redirect()->to('/admin')->with('success', 'Permiso creado exitosamente');
        }

        return redirect()->to('/admin')->with('error', 'Error al crear el permiso');
    }

    // Asignar un permiso a un rol
    public function assignPermissionToRole()
    {
        $permissionId = $this->request->getPost('permission_id');
        $roleId = $this->request->getPost('role_id');

        if ($permissionId && $roleId) {
            $this->rbac->Roles->assign($permissionId, $roleId);
            return redirect()->to('/admin')->with('success', 'Permiso asignado al rol');
        }

        return redirect()->to('/admin')->with('error', 'Error al asignar el permiso');
    }

    // Asignar un rol a un usuario
    public function assignRoleToUser()
    {
        $userId = $this->request->getPost('user_id');
        $roleId = $this->request->getPost('role_id');

        if ($userId && $roleId) {
            $db = \Config\Database::connect();
            $db->table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId,
            ]);

            return redirect()->to('/admin')->with('success', 'Rol asignado al usuario');
        }

        return redirect()->to('/admin')->with('error', 'Error al asignar el rol al usuario');
    }

    // Eliminar permisos asignados a roles
    public function deleteRolePermission()
    {
        if ($this->request->isAJAX()) {
            $roleId = $this->request->getJSON()->role_id;
            $permissionId = $this->request->getJSON()->permission_id;

            if ($roleId && $permissionId) {
                $db = \Config\Database::connect();
                $db->table('users_rolepermissions')
                    ->where('RoleID', $roleId)
                    ->where('PermissionID', $permissionId)
                    ->delete();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Role-Permission assignment deleted successfully.'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid RoleID or PermissionID.'
            ]);
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
}
