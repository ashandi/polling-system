<?php

namespace System;

abstract class Provider
{
    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->container = Container::getInstance();
    }

    /**
     * Method binds injection to container
     *
     * @param string $interfaceName
     * @param string $className
     */
    protected function bind(string $interfaceName, string $className) : void
    {
        $this->container->bind($interfaceName, $className);
    }

    /**
     * Container calls this method from all registered providers
     *
     * @return mixed
     */
    public abstract function register();

}