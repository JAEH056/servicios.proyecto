<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Reposs\AdminController;
use App\Controllers\Reposs\OpenUseController;
/// ----------- DRPSS Controllers ------------
use App\Controllers\Reposs\MenusDRPSS\Residentes;
use App\Controllers\Reposs\MenusDRPSS\Residente;
use App\Controllers\Reposs\MenusDRPSS\Empresa;
use App\Controllers\Reposs\MenusDRPSS\AsesorInterno;
use App\Controllers\Reposs\MenusDRPSS\HomeDRPSS;
/// ----------- Residentes Controllers ------------
//use App\Controllers\Reposs\MenusResidente\InicioResidente;
use App\Controllers\Reposs\MenusResidente\Documentos;
use App\Controllers\Reposs\MenusResidente\DatosEmpresa;
use App\Controllers\Reposs\MenusResidente\HomeResidente;
use App\Controllers\Reposs\MenusResidente\DatosProyecto;
use App\Controllers\Reposs\MenusResidente\DatosResidente;
use App\Controllers\Reposs\MenusResidente\DocumentosRes;

/**
 * @var RouteCollection $routes
 */

// Rutas usuario: Residente con: permisos por defecto (default)
$routes->group('usuario', ['filter' => 'rbac:default'], function ($routes) {
    $routes->get('residentes/admin',        [OpenUseController::class, 'index']);
    $routes->get('residentes/documentos',   [Documentos::class, 'index']);
    $routes->get('residentes/datos',        [DatosResidente::class, 'index']);
    $routes->get('residentes/proyecto',     [DatosProyecto::class, 'index']);
    $routes->get('residentes/home',         [HomeResidente::class, 'index']);
    $routes->get('residentes/empresa',      [DatosEmpresa::class, 'index']);
    $routes->post('residentes/datos',       [DatosResidente::class, 'guardar']);
    $routes->post('residentes/documentos',  [Documentos::class, 'upload']);

    $routes->post('residentes/upload/(:num)',  [DocumentosRes::class, 'upload2']);
    $routes->get('residentes/delete/(:num)',   [DocumentosRes::class, 'delete']);
});

// Rutas de departamento de residencias profecionales: Usuario con permisos de root
$routes->group('usuario', ['filter' => 'rbac:puesto'], function ($routes) {
    $routes->get('drpss/residentes',   [Residentes::class, 'index']);
    $routes->get('drpss/nuevo',        [Residente::class, 'index']);
    $routes->get('drpss/empresa',      [Empresa::class, 'index']);
    $routes->get('drpss/asesor',       [AsesorInterno::class, 'index']);
    $routes->get('drpss/home',         [HomeDRPSS::class, 'index']);
    $routes->post('drpss/nuevo',       [Residente::class, 'guardar']);
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