<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/usuarios', 'Users::index');
$routes->post('/login', 'Users::login');
$routes->post('/usuarios', 'Users::create');
$routes->delete('/usuarios/(:num)', 'Users::delete/$1');
$routes->patch('/usuarios/update/(:num)', 'Users::update/$1');
