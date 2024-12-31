<?php


use App\Controllers\Labs\MenuLaboratorista\CrearHorario;
use App\Controllers\Labs\MenuLaboratorista\DiasInhabiles;
use App\Controllers\Labs\MenuLaboratorista\Laboratorios;
use App\Controllers\Labs\MenuLaboratorista\Laboratorista;
use App\Controllers\Labs\MenuLaboratorista\Reticula;
use App\Controllers\Labs\MenuLaboratorista\Semestre;
use App\Controllers\Labs\MenuUsuario\SolicitarLaboratorio;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// SEMESTRE
$routes->group('usuario', ['filter' => 'rbac:puesto'], function ($routes) {
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

    //RETICULA
    $routes->get('reticula', [Reticula::class, 'index']);
    $routes->get('reticula/(:num)', [Reticula::class, 'index']);
});

//Usuarios con correo huatusco.tecnm.mx
    $routes->group('usuario', ['filter' => 'rbac:puesto'], function ($routes) {
        $routes->get('empleado/horario/(:num)', [SolicitarLaboratorio::class, 'index/$1']);
        $routes->get('ver/horario', [SolicitarLaboratorio::class, 'index']);
       //para peticion de materia con base a carrera
        $routes->get('pr/horario', [SolicitarLaboratorio::class,'obtenerMateriasCarrera']);
        $routes->get('asignaturaclave/horario', [SolicitarLaboratorio::class,'obtenerClavePorMateria']);
       
        $routes->get('datos', [SolicitarLaboratorio::class, 'enviarSolicitud']);

});
