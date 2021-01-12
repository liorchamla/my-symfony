<?php

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class IndexTest extends TestCase
{
    public function testHello()
    {
        $request = Request::create('/hello/Lior');

        $routes = require __DIR__ . '/../src/routes.php';

        $framework = new \Simplex\Framework(new UrlMatcher($routes, new RequestContext()), new ControllerResolver(), new ArgumentResolver());

        $response = $framework->handle($request);

        $this->assertEquals('Hello Lior', $response->getContent());
    }

    public function testAbout()
    {
        $request = Request::create('/a-propos');

        $routes = require __DIR__ . '/../src/routes.php';

        $framework = new \Simplex\Framework(new UrlMatcher($routes, new RequestContext()), new ControllerResolver(), new ArgumentResolver());

        $response = $framework->handle($request);

        $this->assertStringContainsString('A propos de nous', $response->getContent());
    }
}
