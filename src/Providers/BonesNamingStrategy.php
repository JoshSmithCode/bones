<?php

namespace App\Providers;


use Doctrine\ORM\Mapping\NamingStrategy;
use ReflectionClass;

class BonesNamingStrategy implements NamingStrategy
{
    function classToTableName($className)
    {
        // TODO: Implement classToTableName() method.
        $reflection = new ReflectionClass($className);

        return ltrim(
            strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $reflection->getShortName())), '_'
        );
    }

    function propertyToColumnName($propertyName, $className = null)
    {
        // TODO: Implement propertyToColumnName() method.
    }

    function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null)
    {
        // TODO: Implement embeddedFieldToColumnName() method.
    }

    function referenceColumnName()
    {
        // TODO: Implement referenceColumnName() method.
    }

    function joinColumnName($propertyName)
    {
        // TODO: Implement joinColumnName() method.
    }

    function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        // TODO: Implement joinTableName() method.
    }

    function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        // TODO: Implement joinKeyColumnName() method.
    }

}