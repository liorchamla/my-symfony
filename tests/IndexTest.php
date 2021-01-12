<?php

use Framework\Simplex;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class IndexTest extends TestCase
{
    protected Simplex $framework;

    protected function setUp(): void
    {
        $routes = require __DIR__ . '/../src/routes.php';

        $urlMatcher = new UrlMatcher($routes, new RequestContext());
        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();
        $dispatcher = new EventDispatcher;

        $this->framework = new Simplex($dispatcher, $urlMatcher, $controllerResolver, $argumentResolver);
    }

    public function testHello()
    {
        $request = Request::create('/hello/Lior');

        $response = $this->framework->handle($request);

        $this->assertEquals('Hello Lior', $response->getContent());
    }

    public function testBye()
    {
        $request = Request::create('/bye');

        $response = $this->framework->handle($request);

        $this->assertEquals('<h1>Goodbye!</h1>', $response->getContent());
    }
}
