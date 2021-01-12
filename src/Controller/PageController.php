<?php

namespace App\Controller;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class PageController
{

    public function about()
    {
        ob_start();
        include __DIR__ . '/../pages/cms/about.php';

        // Renvoyer la response
        return new Response(ob_get_clean());
    }
}
