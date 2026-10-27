<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Ruta para mostrar la vista del login (GET)
$routes->get('login', 'Home::index'); 

// Ruta para recibir los datos del formulario (POST)
$routes->post('login', 'Auth::login');

// Ruta para cerrar sesión
$routes->get('logout', 'Auth::logout');