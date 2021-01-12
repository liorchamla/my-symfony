<?php

namespace App\Controller;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

class GreetingController
{
    public function __construct(EventDispatcher $dispatcher, int $age, ArgumentResolver $argumentResolver)
    {
    }

    public function hello($name, Request $request)
    {
        // $name = $request->attributes->get('name');

        // Intégrer du HTML
        ob_start();
        include __DIR__ . '/../pages/hello.php';

        // Renvoyer la response
        return new Response(ob_get_clean());
    }

    public function bye()
    {
        ob_start();
        include __DIR__ . '/../pages/bye.php';

        // Renvoyer la response
        return new Response(ob_get_clean());
    }
}
