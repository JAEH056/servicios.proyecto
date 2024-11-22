<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Reposs\OpenUseController;

/**
 * @var RouteCollection $routes
 */

 $routes->get('residentes/dashboard', [OpenUseController::class,'index']);