<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/portfolio', 'PortfolioController::index');
$routes->match(['get', 'post'], '/portfolio/create','PortfolioController::create');
$routes->match(['get', 'post'], '/portfolio/update/(:num)','PortfolioController::update/$1');
$routes->delete('/portfolio/delete/(:num)','PortfolioController::destroy/$1');
