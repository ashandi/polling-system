<?php

namespace System;

class Handler
{

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $method;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param string $class
     * @param string $method
     */
    public function __construct(string $class, string $method)
    {
        $this->class = $class;
        $this->method = $method;
        $this->container = Container::getInstance();
    }

    /**
     * Method invokes method of class which must handle Request and must return Response
     *
     * @param Request $request
     * @return Response
     */
    public function invoke(Request $request) : Response
    {
        $class = $this->container->make($this->class);

        return call_user_func([
            $class,
            $this->method
        ], $request);
    }

}