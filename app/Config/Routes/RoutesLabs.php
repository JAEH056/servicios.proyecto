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
    $routes->get('mostrar/semestre', [Semestre::class, 'index']);
    $routes->get('nuevo/semestre', [Semestre::class, 'nuevo']);
    $routes->get('editar/semestre/(:num)', [Semestre::class, 'editar/$1']);
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
    $routes->get('horario/(:num)', [CrearHorario::class, 'index/$1']); // Con ID, muestra el horario
    $routes->get('horario', [CrearHorario::class, 'index']); // Con ID, muestra el horario
    // para mostrar todos los eventos del horario 
    $routes->get('mostrar/eventos',[CrearHorario::class,'eventos']);

    //RETICULA
    $routes->get('reticula', [Reticula::class, 'index']);
    $routes->get('reticula/(:num)', [Reticula::class, 'index']);
});

//Usuarios con correo huatusco.tecnm.mx
$routes->group('usuario', ['filter' => 'rbac:puesto'], function ($routes) {
    $routes->get('empleado/horario/(:num)', [SolicitarLaboratorio::class, 'index/$1']);
    $routes->get('ver/horario', [SolicitarLaboratorio::class, 'index']);
    //para peticion de materia con base a carrera
    $routes->get('pr/horario', [SolicitarLaboratorio::class, 'obtenerMateriasCarrera']);
    $routes->get('asignaturaclave/horario', [SolicitarLaboratorio::class, 'obtenerClavePorMateria']);


    // mostrar eventos 
    $routes->get('eventos/empleados', [SolicitarLaboratorio::class, 'eventosLaboratorio']);


    //enviar solicitud tipo varias
    $routes->post('solicitud', [SolicitarLaboratorio::class, 'enviarSolicitud']);
});
