<?php

namespace App;

use App\Providers\ProviderInterface;
use ReflectionClass;
use ReflectionMethod;

class Container
{
    private $interfaces = [];

    private $providers = [];

    private $cache = [];

    public function bind(string $interface, string $implementation)
    {
        $this->interfaces[$interface] = $implementation;
    }

    public function register(string $key, ProviderInterface $provider)
    {
        $this->providers[$key] = $provider;
    }

    public function store($key, $value)
    {
        $this->cache[$key] = $value;
    }

    public function get(string $key)
    {
        if(isset($this->cache[$key]))
        {
            return $this->cache[$key];
        }

        ## Check for an interface request
        if(isset($this->interfaces[$key]))
        {
            return $this->get($this->interfaces[$key]);
        }

        ## Check for a provider
        if(isset($this->providers[$key]))
        {
            /** @var ProviderInterface $provider */
            $provider = $this->providers[$key];
            $dependency = $provider->build($this);
            $this->cache[$key] = $dependency;

            return $dependency;
        }

        ## Fallback to reflection
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

            if($param->getClass() == null)
            {
                var_dump($constructorParams);die;
            }

            $builtParams[] = $this->get($param->getClass()->getName());
        }

        $dependency = new $key(...$builtParams);
        $this->cache[$key] = $dependency;

        return $dependency;
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