<?php

$routes = new NW\Route\RouteCollection();

$routes->get('home', '/', 'MainController@index');
$routes->get('profile', '/profile', 'ProfileController@index');
$routes->get('login', '/login', 'ProfileController@formLogin');

return new NW\Route\Router($routes);
