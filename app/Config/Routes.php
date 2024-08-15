<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'User::index');
$routes->post('/', 'User::genUrl', ['as' => 'url.genUrl']);

$routes->get('(:any)', 'User::redirect');
