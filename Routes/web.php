<?php

$routes = new NW\Route\RouteCollection();

$routes->get('home', '/', 'MainController@index');

return new NW\Route\Router($routes);
