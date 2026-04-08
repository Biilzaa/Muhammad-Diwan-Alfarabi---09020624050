<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');


$routes->get('siswa', 'Siswa::index');
$routes->get('siswa/edit/(:num)', 'Siswa::index/$1');
$routes->post('siswa/save', 'Siswa::save');
$routes->post('siswa/delete/(:num)', 'Siswa::delete/$1');
$routes->post('siswa/getKabko/(:num)', 'Siswa::getKabko/$1');
