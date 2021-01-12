<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


$routes = new RouteCollection;

$routes->add('hello', new Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'App\Controller\GreetingController::hello'
]));
$routes->add('bye', new Route('/bye', [
    '_controller' => 'App\Controller\GreetingController::bye'
]));
$routes->add('cms/about', new Route('/a-propos', [
    '_controller' => 'App\Controller\PageController::about'
]));

return $routes;
