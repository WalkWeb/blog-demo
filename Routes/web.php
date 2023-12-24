<?php

$routes = new NW\Route\RouteCollection();

$routes->get('home', '/', 'MainController@index');
$routes->get('profile', '/profile', 'ProfileController@index');

return new NW\Route\Router($routes);
