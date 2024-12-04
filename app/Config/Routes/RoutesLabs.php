<?php

use App\Controllers\Labs\DiasInhabiles;
use App\Controllers\Labs\Laboratorios;
use App\Controllers\Labs\Semestre;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 $routes->get('semestre', [Semestre::class,'index']);
 $routes->get('semestre/nuevo', [Semestre::class, 'nuevo']);
 $routes->post('crear',[Semestre::class, 'crear']);
 $routes->get('semestre/editar/(:num)', [Semestre::class, 'editar/$1']);
 $routes->post('semestre/actualizar/(:num)',[Semestre::class,'actualizar/$1']);
 $routes->get('semestre/eliminar/(:num)',[Semestre::class, 'eliminar/$1']);
 $routes->get('laboratorio', [Laboratorios::class,'index']);
 $routes->get('laboratorio/nuevo', [Laboratorios::class, 'nuevo']);
 $routes->post('laboratorio/crear',[Laboratorios::class, 'crear']);
 
 $routes->get('diasinhabiles', [DiasInhabiles::class, 'index']);
 $routes->get('nuevo/lab', [DiasInhabiles::class, 'formularioDias']);
 $routes->post('dias_inhabiles/crear', [DiasInhabiles::class, 'crearDiaInhabil']);
 $routes->get('dias_inhabiles/editar/(:num)', [DiasInhabiles::class, 'editar/$1']);
 $routes->post('dias_inhabiles/actualizar/(:num)', [DiasInhabiles::class, 'actualizarDiaInhabil/$1']);
 $routes->get('dias_inhabiles/eliminar/(:num)',[DiasInhabiles::class, 'eliminar/$1']);
