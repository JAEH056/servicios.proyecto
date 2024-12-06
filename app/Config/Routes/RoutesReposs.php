<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Reposs\AdminController;
use App\Controllers\Reposs\OpenUseController;
//use App\Controllers\Reposs\MenusResidente\InicioResidente;
use App\Controllers\Reposs\MenusResidente\ActualizaDatos;
use App\Controllers\Reposs\MenusResidente\SubirDocumentos;
use App\Controllers\Reposs\MenusDRPSS\NuevoResidente;
use App\Controllers\Reposs\MenusDRPSS\NuevaEmpresa;
use App\Controllers\Reposs\MenusDRPSS\NuevoAsesor;
use App\Controllers\Reposs\MenusResidente\DatosEmpresa;
use App\Controllers\Reposs\MenusResidente\HomeResidente;
use App\Controllers\Reposs\MenusResidente\DatosProyecto;

/**
 * @var RouteCollection $routes
 */

// Rutas usuario: Residente con: permisos por defecto (default)
$routes->group('usuario', ['filter' => 'rbac:default'], function ($routes) {
    $routes->get('residentes/admin',        [OpenUseController::class, 'index']);
    $routes->get('residentes/home',         [HomeResidente::class, 'index']);
    $routes->get('residentes/datos',        [ActualizaDatos::class, 'index']);
    $routes->get('residentes/documentos',   [SubirDocumentos::class, 'index']);
    $routes->get('residentes/empresa',      [DatosEmpresa::class, 'index']);
    $routes->get('residentes/proyecto',     [DatosProyecto::class, 'index']);
});

// Rutas de departamento de residencias profecionales: Usuario con permisos de root
$routes->group('usuario', ['filter' => 'rbac:default'], function ($routes) {
    $routes->get('drpss/nuevo',     [NuevoResidente::class, 'index']);
    $routes->get('drpss/empresa',   [NuevaEmpresa::class, 'index']);
    $routes->get('drpss/asesor',    [NuevoAsesor::class, 'index']);
});

// Rutas administrador de roles y permisos con acceso solo para roles con permisos de root
$routes->group('admin', ['filter' => 'rbac:root'], function ($routes) {
    $routes->get('/',                            [AdminController::class, 'index']);
    $routes->post('createRole',                  [AdminController::class, 'createRole']);
    $routes->post('deleteRole',                  [AdminController::class, 'deleteRole']);
    $routes->post('createPermission',            [AdminController::class, 'createPermission']);
    $routes->post('assignPermissionToRole',      [AdminController::class, 'assignPermissionToRole']);
    $routes->post('assignRoleToUser',            [AdminController::class, 'assignRoleToUser']);
    $routes->post('deleteRolePermission',        [AdminController::class, 'deleteRolePermission']);
});