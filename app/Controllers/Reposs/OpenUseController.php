<?php

namespace App\Controllers\Reposs;

use App\Controllers\BaseController;
use App\Models\Roles\RolesModel;
use App\Models\Roles\PermissionsModel;
use App\Models\Roles\RolePermissionsModel;

class OpenUseController extends BaseController
{
    public function index(): string
    {
        // Se cargan los modelos de los roles, permisos y asignaciones de permisos
        $roleModel = new RolesModel();
        $permissionModel = new PermissionsModel();
        $rolePermissionModel = new RolePermissionsModel();

        // Se obtiene la consulta de cada uno de los modelos con su respectiva funcion
        $roles['roles'] = $roleModel->getRoles();
        $permissions['permissions'] = $permissionModel->getPermissions();
        $rolePermissions['rolePermissions'] = $rolePermissionModel->getRolePermissions();
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/adminPage', ['user' => $user, 'token' => $token, 'idusuario' => $userId, 'roles' => $roles['roles'], 'permissions' => $permissions['permissions'], 'rolePermissions' => $rolePermissions['rolePermissions']]);
    }
}
