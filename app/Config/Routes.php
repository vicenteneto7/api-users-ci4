<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/users', 'Users::index');
$routes->post('/', 'Users::create');
$routes->get('/users/(:num)', 'Users::delete/$1');
