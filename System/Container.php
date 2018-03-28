<?php

namespace System;

use ReflectionClass;

class Container
{

    /**
     * @var array
     */
    private $providers = [];

    /**
     * @var Container
     */
    private static $instance;

    private function __construct() { }
    private function __clone() { }

    /**
     * Pattern Singleton
     *
     * @return Container
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Method registers given injection to this->providers
     *
     * @param string $interfaceName
     * @param string $className
     */
    public function bind(string $interfaceName, string $className) : void
    {
        $this->providers[$interfaceName] = $className;
    }

    /**
     * Method calls register methods of all registered providers
     *
     * @param array $providers
     */
    public function registerAll(array $providers) : void
    {
        foreach ($providers as $providerName) {
            $provider = new $providerName();
            $provider->register();
        }
    }

    /**
     * Realization of IoC
     *
     * @param string $className
     * @return object
     */
    public function make(string $className)
    {
        $reflection = new ReflectionClass($className);

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $constructorParams = $constructor->getParameters();

        $paramClasses = [];
        foreach ($constructorParams as $constructorParam) {
            $paramClass = $constructorParam->getClass();

            if (array_key_exists($paramClass->getName(), $this->providers)) {
                $paramClasses[$constructorParam->getName()] = self::make($this->providers[$paramClass->getName()]);
            } else {
                $paramClasses[$constructorParam->getName()] = $paramClass->isInstantiable()
                    ? $paramClasses[$constructorParam->getName()] = $paramClass->newInstance()
                    : $paramClass->newInstanceWithoutConstructor();
            }
        }

        return $reflection->newInstanceArgs($paramClasses);
    }

}