<?php

namespace Framework\Resolver;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class ContainerControllerResolver extends ControllerResolver
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
    {
        parent::__construct($logger);

        $this->container = $container;
    }

    protected function instantiateController(string $class)
    {
        // Demander au container d'instancier le controller
        return $this->container->get($class);
    }
}
