<?php

namespace Framework\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

class RequestEvent extends Event
{
    protected Request $request;
    protected ?Response $response = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }
}
