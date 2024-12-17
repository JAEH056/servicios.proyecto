<?php

use App\Controllers\Labs\CrearHorario;
use App\Controllers\Labs\DiasInhabiles;
use App\Controllers\Labs\Laboratorios;
use App\Controllers\Labs\Laboratorista;
use App\Controllers\Labs\PuestoEmpleado;
use App\Controllers\Labs\Reticula;
use App\Controllers\Labs\Semestre;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// SEMESTRE
$routes->get('semestre/mostrar', [Semestre::class,'index']);
$routes->get('semestre/nuevo', [Semestre::class, 'nuevo']);
$routes->post('semestre/crear',[Semestre::class, 'crear']);
$routes->get('semestre/editar/(:num)', [Semestre::class, 'editar/$1']);
$routes->post('semestre/actualizar/(:num)',[Semestre::class,'actualizar/$1']);
$routes->get('semestre/eliminar/(:num)',[Semestre::class, 'eliminar/$1']);

// LABORATORIO
$routes->get('laboratorio', [Laboratorios::class, 'index']);
$routes->get('laboratorio/nuevo', [Laboratorios::class, 'nuevo']);
$routes->post('laboratorio/crear', [Laboratorios::class, 'crear']);
$routes->get('laboratorio/editar/(:num)', [Laboratorios::class, 'editar/$1']);
$routes->post('laboratorio/actualizar/(:num)', [Laboratorios::class, 'actualizar/$1']);
$routes->get('laboratorio/eliminar/(:num)', [Laboratorios::class, 'eliminar/$1']);

// DIAS INHABILES 
 $routes->get('diasinhabiles', [DiasInhabiles::class, 'index']);
 $routes->get('diasinhabiles/nuevo', [DiasInhabiles::class, 'nuevo']);
 $routes->post('diasinhabiles/crear', [DiasInhabiles::class, 'crear']);
 $routes->get('diasinhabiles/editar/(:num)', [DiasInhabiles::class, 'editar/$1']);
 $routes->post('diasinhabiles/actualizar/(:num)', [DiasInhabiles::class, 'actualizar/$1']);
 $routes->get('diasinhabiles/eliminar/(:num)',[DiasInhabiles::class, 'eliminar/$1']);

 $routes->get('laboratorista', [Laboratorista::class, 'index']);
 // HORARIO 
 $routes->get('horario/(:num)', [CrearHorario::class, 'verHorario/$1']); // Con ID, muestra el horario
 $routes->get('horario', [CrearHorario::class, 'verHorario']); // Con ID, muestra el horario
  
 $routes->get('puesto',[PuestoEmpleado::class,'index']);

 $routes->get('reticula',[Reticula::class,'index']);
 $routes->get('reticula/(:num)',[Reticula::class,'index']);

//  $routes->get('horario/nuevo', [CrearHorario::class, 'nuevo']);
//  $routes->post('horario/crear',[CrearHorario::class, 'crear']);
//  $routes->get('horario/laboratorio/(:num)',[CrearHorario::class, 'mostrarHorario/$1']);


 


