<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/', 'LoginController::index');
$routes->get('login', 'LoginController::index');
$routes->post('LoginController/autenticar', 'LoginController::autenticar');
$routes->get('LoginController/salir', 'LoginController::salir');
$routes->get('LoginController/generarClave', 'LoginController::generarClave');


// Panel de control
$routes->get('admin/inicio', 'AdministradorController::index');

// Operaciones CRUD
$routes->post('admin/agregarUsuario', 'AdministradorController::agregarUsuario');
$routes->post('admin/editarUsuario', 'AdministradorController::editarUsuario');
$routes->get('admin/eliminarUsuario/(:num)', 'AdministradorController::eliminarUsuario/$1');