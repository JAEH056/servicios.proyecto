<?php

use App\Controllers\Home;
use App\Controllers\Labs\CrearHorario;
use App\Controllers\Labs\DiasInhabiles;
use App\Controllers\Labs\HomeLabs;
use App\Controllers\Labs\Laboratorios;
use App\Controllers\Labs\Laboratorista;
use App\Controllers\Labs\PuestoEmpleado;
use App\Controllers\Labs\Reticula;
use App\Controllers\Labs\Semestre;
use App\Controllers\Puestos\Puesto;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// SEMESTRE
$routes->group('usuario', ['filter' => 'rbac:puesto'], function ($routes) {
    $routes->get('laboratorista/home', [HomeLabs::class, 'index']);
    $routes->get('semestre/mostrar', [Semestre::class, 'index']);
    $routes->get('semestre/nuevo', [Semestre::class, 'nuevo']);
    $routes->get('semestre/editar/(:num)', [Semestre::class, 'editar/$1']);
    $routes->get('semestre/eliminar/(:num)', [Semestre::class, 'eliminar/$1']);
    $routes->post('semestre/actualizar/(:num)', [Semestre::class, 'actualizar/$1']);
    $routes->post('semestre/crear', [Semestre::class, 'crear']);

    // LABORATORIO
    $routes->get('laboratorio', [Laboratorios::class, 'index']);
    $routes->get('laboratorio/nuevo', [Laboratorios::class, 'nuevo']);
    $routes->get('laboratorio/editar/(:num)', [Laboratorios::class, 'editar/$1']);
    $routes->get('laboratorio/eliminar/(:num)', [Laboratorios::class, 'eliminar/$1']);
    $routes->post('laboratorio/crear', [Laboratorios::class, 'crear']);
    $routes->post('laboratorio/actualizar/(:num)', [Laboratorios::class, 'actualizar/$1']);

    // DIAS INHABILES 
    $routes->get('diasinhabiles', [DiasInhabiles::class, 'index']);
    $routes->get('diasinhabiles/nuevo', [DiasInhabiles::class, 'nuevo']);
    $routes->get('diasinhabiles/editar/(:num)', [DiasInhabiles::class, 'editar/$1']);
    $routes->get('diasinhabiles/eliminar/(:num)', [DiasInhabiles::class, 'eliminar/$1']);
    $routes->post('diasinhabiles/crear', [DiasInhabiles::class, 'crear']);
    $routes->post('diasinhabiles/actualizar/(:num)', [DiasInhabiles::class, 'actualizar/$1']);

    //LABORATORISTA
    $routes->get('laboratorista', [Laboratorista::class, 'index']);
    // HORARIO 
    $routes->get('horario/(:num)', [CrearHorario::class, 'verHorario/$1']); // Con ID, muestra el horario
    $routes->get('horario', [CrearHorario::class, 'verHorario']); // Con ID, muestra el horario

    // Puesto Empleado
    //$routes->get('puesto',[PuestoEmpleado::class,'index']);

    //RETICULA
    $routes->get('reticula', [Reticula::class, 'index']);
    $routes->get('reticula/(:num)', [Reticula::class, 'index']);

    //  $routes->get('horario/nuevo', [CrearHorario::class, 'nuevo']);
    //  $routes->post('horario/crear',[CrearHorario::class, 'crear']);
    //  $routes->get('horario/laboratorio/(:num)',[CrearHorario::class, 'mostrarHorario/$1']);

});
$routes->group('usuario', ['filter' => 'rbac:puesto'], function ($routes) {
// $routes->get('puesto',                     [Puesto::class, 'index']);     // Step 4
});