<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('cliente', 'ClienteController::index');
$routes->post('cliente', 'ClienteController::create');
$routes->put('cliente/(:num)', 'ClienteController::update/$1');
$routes->delete('cliente/(:num)', 'ClienteController::delete/$1');

$routes->get('produto', 'ProdutoController::index');
$routes->post('produto', 'ProdutoController::create');
$routes->put('produto/(:num)', 'ProdutoController::update/$1');
$routes->delete('produto/(:num)', 'ProdutoController::delete/$1');



