<?php

use App\Controller\GreetingController;
use App\Controller\PageController;
use Framework\Event\RequestEvent;
use Framework\Resolver\ContainerControllerResolver;
use Framework\Simplex;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Contracts\EventDispatcher\Event;

require __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../src/routes.php';
$container =  require __DIR__ . '/../src/container.php';

// Travail du framework
$request = Request::createFromGlobals();
$framework = $container->get(Simplex::class);
$response = $framework->handle($request);
$response->send();
