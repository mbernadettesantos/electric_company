<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->match(['get', 'post'], '/contact', 'Contact::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');

// Customer account management.
$routes->match(['get', 'post'], '/login', 'AccountManagement::login');
$routes->get('/dashboard', 'AccountManagement::dashboard');
$routes->get('/account/create', 'AccountManagement::createAccount');
$routes->post('/account/create', 'AccountManagement::storeAccount');
$routes->get('/account/(:num)', 'AccountManagement::viewAccount/$1');
$routes->get('/account/(:num)/edit', 'AccountManagement::editAccount/$1');
$routes->post('/account/(:num)/edit', 'AccountManagement::updateAccount/$1');
$routes->post('/account/(:num)/delete', 'AccountManagement::deleteAccount/$1');
$routes->post('/logout', 'AccountManagement::logout');
