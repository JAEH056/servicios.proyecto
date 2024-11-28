<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\OAuthlogin\OAuthController;
use App\Controllers\Reposs\AdminController;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

//rutas de acceso codeigniter shield
//service('auth')->routes($routes);

//Sara y Vianey, coloquen sus rutas en:
// Mueve esta ruta al archivo correcto.

require_once __DIR__ . '/Routes/RoutesLabs.php';

//Alejandro, coloquen sus rutas en:
require_once __DIR__ . '/Routes/RoutesReposs.php';

/// Rutas OAuth autentication 
$routes->get('/oauth/login',                [OAuthController::class, 'login']);      // Step 1
$routes->get('/oauth/microsoft/callback',   [OAuthController::class, 'callback']);   // Step 2
$routes->get('/dashboard',                  [OAuthController::class, 'dashboard']);  // Step 3, este debe colocarse en ontro Controller.
$routes->get('/logout',                     [OAuthController::class, 'logout']);     // Step 4

// Rutas administrador de roles y permisos
$routes->get('admin',                             [AdminController::class, 'index']);
$routes->post('admin/createRole',                 [AdminController::class, 'createRole']);
$routes->post('admin/deleteRole',                 [AdminController::class, 'deleteRole']);
$routes->post('admin/createPermission',           [AdminController::class, 'createPermission']);
$routes->post('admin/assignPermissionToRole',     [AdminController::class, 'assignPermissionToRole']);
$routes->post('admin/assignRoleToUser',           [AdminController::class, 'assignRoleToUser']);
$routes->post('admin/deleteRolePermission',       [AdminController::class, 'deleteRolePermission']);