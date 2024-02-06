<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/usuarios', 'Users::listUser');
$routes->post('/login', 'Login::login');
$routes->post('/cadastrar-usuario', 'Users::create');
$routes->delete('/usuarios/(:num)', 'Users::delete/$1');
$routes->patch('/usuarios/update/(:num)', 'Users::update/$1');
