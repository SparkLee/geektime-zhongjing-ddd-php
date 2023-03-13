<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionException;

class RequestMapper
{
    private Request $request;

    /**
     * @throws ReflectionException
     */
    public static function map(Request $request, string $dtoClassName): object
    {
        $mapper = new static();
        $mapper->request = $request;
        return $mapper->reflect($dtoClassName);
    }

    /**
     * @throws ReflectionException
     */
    private function reflect(string $dtoClassName): object
    {
        $reflectionClass = new ReflectionClass($dtoClassName);
        $object = $reflectionClass->newInstanceWithoutConstructor();
        $reflectionProperties = $reflectionClass->getProperties();
        foreach ($reflectionProperties as $reflectionProperty) {
            $propertyName = $reflectionProperty->getName();
            if ($this->request->exists($propertyName)) {
                $reflectionProperty->setValue($object, $this->request->get($propertyName));
            }
        }
        return $object;
    }
}
