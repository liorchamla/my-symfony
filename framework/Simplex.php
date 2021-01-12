<?php

namespace Framework;

use Exception;
use Framework\Event\ArgumentEvent;
use Framework\Event\ControllerEvent;
use Framework\Event\RequestEvent;
use Framework\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class Simplex
{
    protected UrlMatcherInterface $urlMatcher;
    protected ControllerResolverInterface $controllerResolver;
    protected ArgumentResolverInterface $argumentResolver;
    protected EventDispatcherInterface $dispatcher;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        UrlMatcherInterface $urlMatcher,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver
    ) {
        $this->dispatcher = $dispatcher;
        $this->urlMatcher = $urlMatcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request)
    {
        $this->urlMatcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));

            $event = new RequestEvent($request);
            $this->dispatcher->dispatch($event, 'kernel.request');
            if ($event->getResponse() !== null) {
                return $event->getResponse();
            }

            $controller = $this->controllerResolver->getController($request);

            $this->dispatcher->dispatch(new ControllerEvent($request, $controller), 'kernel.controller');

            $arguments = $this->argumentResolver->getArguments($request, $controller);

            $this->dispatcher->dispatch(new ArgumentEvent($request, $controller, $arguments), 'kernel.arguments');

            $response = call_user_func_array($controller, $arguments);

            $this->dispatcher->dispatch(new ResponseEvent($response), 'kernel.response');
        } catch (ResourceNotFoundException $e) {
            $response = new Response("Le page demandée n'existe pas", 404);
        } catch (Exception $e) {
            $response = new Response("Une erreur est survenue", 500);
        }

        return $response;
    }
}
