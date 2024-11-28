<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $rbac = service('rbac');
        $userId = session()->get('user_id');
        $requiredPermission = $arguments[0] ?? null;

        // Obtener el rol del usuario
        $db = \Config\Database::connect();
        $role = $db->table('user_roles')
            ->where('user_id', $userId)
            ->get()
            ->getRowArray();

        if (!$role || !$rbac->check($requiredPermission, $role['role_id'])) {
            return redirect()->to('/acceso-denegado');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // No se necesita implementar nada aquí
    }
}
