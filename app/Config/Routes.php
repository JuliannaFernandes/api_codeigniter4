<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('cliente', 'ClienteController::index', ['filter' => 'authFilter']);
$routes->post('cliente', 'ClienteController::create');
$routes->put('cliente/(:num)', 'ClienteController::update/$1');
$routes->delete('cliente/(:num)', 'ClienteController::delete/$1');

$routes->get('produto', 'ProdutoController::index', ['filter' => 'authFilter']);
$routes->post('produto', 'ProdutoController::create');
$routes->put('produto/(:num)', 'ProdutoController::update/$1');
$routes->delete('produto/(:num)', 'ProdutoController::delete/$1');

$routes->get('pedido', 'PedidoController::index', ['filter' => 'authFilter']);
$routes->post('pedido', 'PedidoController::create');
$routes->put('pedido/(:num)', 'PedidoController::update/$1');
$routes->delete('pedido/(:num)', 'PedidoController::delete/$1');

$routes->post("registro", "RegistroController::index");
$routes->post("login", "LoginController::index");
$routes->get("usuario", "UsuarioController::index", ['filter' => 'authFilter']);
