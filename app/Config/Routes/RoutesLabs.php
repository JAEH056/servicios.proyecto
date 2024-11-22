<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 $routes->get('vista/inicial', 'Labs\Prueba::iniciando');
 $routes->get('vista/opciones', 'Labs\Opciones::opciones');
