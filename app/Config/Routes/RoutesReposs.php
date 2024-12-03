<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Reposs\OpenUseController;
use App\Controllers\Reposs\MenusResidente\InicioResidente;

/**
 * @var RouteCollection $routes
 */

// Rutas usuario: Residente con permisos de root
$routes->group('Usuario', ['filter' => 'rbac:root'], function ($routes) {
    $routes->get('residentes/admin', [OpenUseController::class, 'index']);
    $routes->get('residentes/inicio', [InicioResidente::class, 'index']);
});

$routes->group('admin', ['filter' => 'rbac'], function ($routes) {
    $routes->get('manage', 'AdminController::manage');
});

$routes->group('editor', ['filter' => 'rbac'], function ($routes) {
    $routes->get('edit', 'EditorController::edit');
});

$routes->group('viewer', ['filter' => 'rbac'], function ($routes) {
    $routes->get('view', 'ViewerController::view');
});
