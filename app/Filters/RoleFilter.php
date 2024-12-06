<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //echo '<script>alert("Este es el filtro de roles antes");</script>'; 
        $rbac = service('rbac');
        $userId = session()->get('idusuario'); /// Obtener el id del usuario (provisto por el controllador de la vista)
        $requiredPermission = $arguments[0] ?? null;

        // Revisa si la ruta tiene envia el permiso requerido
        if (!$requiredPermission) {
            // Se maneja el caso en el que el permiso no se envia
            return redirect()->to('/acceso-denegado',)->with('message', 'No se encontro un permiso antes del filtro');
        }
        // Revisa si el usuario tiene el permiso requerido usando su ID (provisto por la sesion/controller)
        if (!$rbac->check($requiredPermission, $userId)) {
            /// echo '<script>alert("Este es el filtro de roles antes"' . $userId . ');</script>';
            return redirect()->to('/dashboard',)->with('message', 'No tienes permiso para acceder a esta sección con UserID:"' . $userId . '". Permiso rquerido: "' . $requiredPermission . '" con permiso en BD: "' . '$myPermisions[Title]' . '"');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita implementar nada aquí...
    }
}
