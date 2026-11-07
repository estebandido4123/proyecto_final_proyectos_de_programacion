<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/', 'LoginController::index');
$routes->get('login', 'LoginController::index');
$routes->post('LoginController/autenticar', 'LoginController::autenticar');
$routes->get('LoginController/salir', 'LoginController::salir');
$routes->get('LoginController/generarClave', 'LoginController::generarClave');