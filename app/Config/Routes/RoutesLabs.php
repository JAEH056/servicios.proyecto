<?php

use App\Controllers\Labs\DiasInhabiles;
use App\Controllers\Labs\Semestre;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 $routes->get('semestre', [Semestre::class,'index']);
 $routes->get('semestre/semestre', [Semestre::class, 'nuevo']);
 
 $routes->get('diasinhabiles', [DiasInhabiles::class, 'index']);
 $routes->get('nuevo/lab', [DiasInhabiles::class, 'formularioDias']);
 $routes->post('dias_inhabiles/crear', [DiasInhabiles::class, 'crearDiaInhabil']);
 $routes->get('dias_inhabiles/editar/(:num)', [DiasInhabiles::class, 'editar/$1']);
 $routes->post('dias_inhabiles/actualizar/(:num)', [DiasInhabiles::class, 'actualizarDiaInhabil/$1']);
 $routes->get('dias_inhabiles/eliminar/(:num)',[DiasInhabiles::class, 'eliminar/$1']);
