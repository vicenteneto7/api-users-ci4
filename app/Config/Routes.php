<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/users', 'Users::listUser');
$routes->post('/first-login', 'Login::login');
$routes->post('/login', 'Login::login');
$routes->post('/cadastrar-usuario', 'Users::create');
$routes->delete('/usuarios/(:num)', 'Users::delete/$1');
$routes->patch('/editar-usuario/(:num)', 'Users::update/$1');