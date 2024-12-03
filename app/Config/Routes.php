<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\OAuthlogin\OAuthController;
use App\Controllers\Reposs\AdminController;
use App\Controllers\Home;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);

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

// Rutas administrador de roles y permisos con acceso solo para roles con permisos de root
$routes->group('admin', ['filter' => 'rbac:root'], function ($routes) {
    $routes->get('/',                            [AdminController::class, 'index']);
    $routes->post('/createRole',                 [AdminController::class, 'createRole']);
    $routes->post('/deleteRole',                 [AdminController::class, 'deleteRole']);
    $routes->post('/createPermission',           [AdminController::class, 'createPermission']);
    $routes->post('/assignPermissionToRole',     [AdminController::class, 'assignPermissionToRole']);
    $routes->post('/assignRoleToUser',           [AdminController::class, 'assignRoleToUser']);
    $routes->post('/deleteRolePermission',       [AdminController::class, 'deleteRolePermission']);
});