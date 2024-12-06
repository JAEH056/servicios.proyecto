<?php

use App\Controllers\Labs\DiasInhabiles;
use App\Controllers\Labs\Horario;
use App\Controllers\Labs\Laboratorios;
use App\Controllers\Labs\Semestre;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// SEMESTRE
$routes->get('semestre', [Semestre::class,'index']);
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

 //HORARIO
 $routes->get('horario', [Horario::class, 'iniciando']);