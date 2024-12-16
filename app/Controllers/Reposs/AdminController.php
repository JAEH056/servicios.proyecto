<?php

namespace App\Controllers\Reposs;

use App\Controllers\BaseController;
use App\Models\Roles\RolePermissionsModel;
use App\Models\Roles\PermissionsModel;
use App\Models\Roles\UserRolesModel;
use App\Models\Roles\RolesModel;

class AdminController extends BaseController
{
    protected $rbac;
    protected $userRoles;
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        // Cargar el servicio PHP-RBAC
        $this->rbac = service('rbac');
        $this->roleModel = new RolesModel();
        $this->userRoles = new UserRolesModel();
        $this->permissionModel = new PermissionsModel();
        $this->rolePermissionModel = new RolePermissionsModel();
    }

    // Vista principal del panel de administración
    public function index()
    {
        // Se obtiene la consulta de cada uno de los modelos con su respectiva funcion
        $roles['roles'] = $this->roleModel->getRoles();
        $userRoles = $this->userRoles->getUserNRoles();
        $permissions['permissions'] = $this->permissionModel->getPermissions();
        $rolePermissions['rolePermissions'] = $this->rolePermissionModel->getRolePermissions();
        // Se carga la vista del panel con los datos de las consultas
        /*
        *   NOTA: Se cargan los datos como arreglo para una funcion adecuada con AJAX based request
        */
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        return view('Reposs/adminPage', ['roles' => $roles['roles'], 'permissions' => $permissions['permissions'], 'rolePermissions' => $rolePermissions['rolePermissions'], 'userRoles' => $userRoles, 'user' => $user, 'token' => $token, 'userId' => $userId]);
    }

    // Crear un rol
    public function createRole()
    {
        // Se obtienen los datos del post para agregar los datos a rbac
        $roleName = $this->request->getPost('role_name');
        $roleDescription = $this->request->getPost('role_description');
        // Si hay datos en el post se procede, caso contrario se manda mensaje de error
        if ($roleName) {
            $this->rbac->Roles->add($roleName, $roleDescription);
            return redirect()->to('/admin')->with('success', 'Rol creado exitosamente');
        }
        return redirect()->to('/admin')->with('error', 'Error al crear el rol');
    }

    // Eliminar un rol
    public function deleteRole()
    {
        // Se determina si la solicitud es AJAX para proceder
        if ($this->request->isAJAX()) {
            $roleId = $this->request->getJSON()->role_id;

            if ($roleId) {  /// Si hay datos en el post se procede, caso contrario se manda mensaje de error
                // Se carga el modelo de roles y se elimina el rol
                //$roleModel = new RolesModel();
                $roleId = $this->request->getPost('roleId'); // Get role ID from the POST data
                // Call the model to delete the role
                $result = $this->roleModel->deleteRole($roleId);

                if ($result) {
                    return $this->response->setJSON([   /// Si los datos son correctos se elimina el rol
                        'success' => true,
                        'message' => 'Role deleted successfully.'
                    ]);
                }
                return $this->response->setJSON([   /// Error en el proceso de eliminacion
                    'success' => false,
                    'message' => 'Failed to delete the role.'
                ]);
            }
            return $this->response->setJSON([   /// Se ingresaron datos invalidos
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
            //$db = \Config\Database::connect(); /// Eliminar conexion
            //$db->table('user_roles')
            $this->userRoles->insert([
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
                //$db = \Config\Database::connect(); /// Eliminar conexion
                //$db->table('users_rolepermissions')
                $this->rolePermissionModel->where('RoleID', $roleId)
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
