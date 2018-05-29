<?php

namespace App;

use ReflectionClass;
use ProviderInterface;
use ReflectionMethod;

class Container
{
    private $interfaces = [];

    private $providers = [];

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function bind(string $interface, string $implementation)
    {
        $this->interfaces[$interface] = $implementation;
    }

    public function register(string $key, ProviderInterface $provider)
    {
        $this->providers[$key] = $provider;
    }

    public function get(string $key)
    {
        ## If the key we're trying to fetch is an interface registered with a binding,
        #  we'll try to fetch the implementation from the container instead
        if(isset($this->interfaces[$key]))
        {
            return $this->get($this->interfaces[$key]);
        }

        if(isset($this->providers[$key]))
        {
            /** @var ProviderInterface $provider */
            $provider = $this->providers[$key];
            return $provider->build($this);
        }

        $reflectionClass = new ReflectionClass($key);

        $constructor = $reflectionClass->getConstructor();

        if(!$constructor)
        {
            return new $key;
        }

        $constructorParams = $reflectionClass->getConstructor()->getParameters();

        $builtParams = [];

        foreach($constructorParams as $param)
        {
            if($param->isOptional()) {
                $builtParams[] = null;
            }

            $builtParams[] = $this->get($param->getClass()->getName());
        }

        return new $key(...$builtParams);
    }

    public function getMethodArgs($controller, string $method)
    {
        $reflectionMethod = new ReflectionMethod($controller, $method);

        $params = [];

        foreach($reflectionMethod->getParameters() as $param)
        {
            $params[] = $this->get($param->getClass()->getName());
        }

        return $params;
    }
}