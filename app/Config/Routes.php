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

$routes->resource('Api/V1/ToDos');

$routes->resource('Api/V1/Categories');

$routes->post('auth/jwt', '\App\Controllers\Auth\LoginController::jwtLogin');

service('auth')->routes($routes);