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

// Operaciones CRUD Libros
$routes->post('admin/agregarLibro', 'AdministradorController::agregarLibro');
$routes->post('admin/editarLibro', 'AdministradorController::editarLibro');
$routes->get('admin/eliminarLibro/(:num)', 'AdministradorController::eliminarLibro/$1');




// Ruta para el inicio del panel de profesor
$routes->get('profesor/inicio', 'ProfesorController::index');

// Rutas de acciones de la biblioteca escolar (Asignación y Devolución)
$routes->post('profesor/asignarLibro', 'ProfesorController::asignarLibro');
$routes->post('profesor/devolverLibro', 'ProfesorController::devolverLibro');