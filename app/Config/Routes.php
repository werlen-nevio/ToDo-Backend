<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('/', 'Home::index');

$routes->resource('api/v1/cars');

$routes->resource('api/v2/cars', ['filter' => 'check_api_key']);

$routes->post('auth/jwt', '\App\Controllers\Auth\LoginController::jwtLogin');

service('auth')->routes($routes);

// $routes->put('api/(:segment )/(:any)', 'Api::update/$1/$2');