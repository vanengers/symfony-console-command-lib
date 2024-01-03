<?php

namespace Vanengers\SymfonyConsoleCommandLib\Tests\Helper;
use ReflectionClass;

class PropertyAccessor
{
    public static function getProperty($object, $property)
    {
        $reflectedClass = new ReflectionClass($object);
        $reflection = $reflectedClass->getProperty($property);
        $reflection->setAccessible(true);
        return $reflection->getValue($object);
    }
}