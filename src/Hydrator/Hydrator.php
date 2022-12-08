<?php

namespace ToBinFree\Hydrator;

use ReflectionClass;
use ReflectionException;

trait Hydrator
{
    private string $___hydratorFootPrint = "___hydrator";
    private array $___hydratorObjectProperties = [];
    private bool $___hydratorAccessorOnly = false;
    private bool $___hydratorMutatorOnly = false;
    private array $___hydratorMethods = [
        ["type" => "getter", "prefix" => "get"],
        ["type" => "getter", "prefix" => "is"],
        ["type" => "setter", "prefix" => "set"],
    ];

    private function ___hasAttribute(array $attributes, string $attributeName): bool
    {
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === $attributeName) {
                return true;
            }
        }
        return false;
    }

    private function ___hasMethod(ReflectionClass $reflectionClass, string $name): bool
    {
        $result = false;
        $parent = $reflectionClass->getParentClass();
        if (false !== $parent) {
            $result = $this->___hasMethod($parent, $name);
        }
        if ($reflectionClass->hasMethod($name)) {
            return true;
        }
        return $result;
    }

    private function initMethods(): void
    {
        $this->___hydratorObjectProperties = [];
        $thisClass = new ReflectionClass($this);
        $properties = $thisClass->getProperties();
        $parent = $thisClass->getParentClass();
        while (false !== $parent) {
            $properties = array_merge($properties, $parent->getProperties());
            $parent = $parent->getParentClass();
        }
        foreach ($properties as $property) {
            $name = $property->getName();
            if (!str_contains($name, $this->___hydratorFootPrint)) {
                if ($this->___hasAttribute($property->getAttributes(), DataProperty::class)) {
                    $this->___hydratorObjectProperties[$name]["type"] = "@DataProperty";
                } else {
                    $this->___hydratorObjectProperties[$name]["type"] = "undefined";
                }
                foreach ($this->___hydratorMethods as $method) {
                    $currentMethod = $method["prefix"] . ucfirst($name);
                    if ($this->___hasMethod($thisClass, $currentMethod)) {
                        $this->___hydratorObjectProperties[$name][$method["type"]] = $currentMethod;
                        break;
                    }
                }
                if (!isset($this->___hydratorObjectProperties[$name]["getter"])) {
                    if (!$this->___hydratorAccessorOnly) {
                        $this->___hydratorObjectProperties[$name]["getter"] = $name;
                    }
                }
                if (!isset($this->___hydratorObjectProperties[$name]["setter"])) {
                    if (!$this->___hydratorAccessorOnly) {
                        $this->___hydratorObjectProperties[$name]["setter"] = $name;
                    }
                }
            }
        }
    }

    public function setMutatorOnly(bool $value): static
    {
        $this->___hydratorMutatorOnly = $value;
        return $this;
    }

    public function setAccessorOnly(bool $value): static
    {
        $this->___hydratorAccessorOnly = $value;
        return $this;
    }

    public function hydrate(array $data, $withNullValue = true):void
    {
        if (empty($this->___hydratorObjectProperties)) {
            $this->initMethods();
        }
        foreach ($data as $key => $value) {
            if ($withNullValue || !is_null($value)) {
                foreach ($this->___hydratorMethods as $method) {
                    if ($method["type"] === "setter") {
                        if (isset($this->___hydratorObjectProperties[$key][$method["type"]])) {
                            $currentMethod = $this->___hydratorObjectProperties[$key][$method["type"]];
                            if (str_starts_with($currentMethod, $method["prefix"])) {
                                $this->$currentMethod($value);
                            } else {
                                $this->$currentMethod = $value;
                            }
                            break;
                        }
                    }
                }
            }
        }
    }

    /**
     * @param bool $dataOnly
     * @param bool $withNullValue
     * @return array
     * @throws ReflectionException
     */
    public function toArray(bool $dataPropertyOnly = false, $withNullValue = true):array
    {
        $result = [];
        if (empty($this->___hydratorObjectProperties)) {
            $this->initMethods();
        }
        foreach ($this->___hydratorObjectProperties as $name => $attributes) {
            if (!$dataPropertyOnly || "@DataProperty" === $attributes["type"]) {
                foreach ($this->___hydratorMethods as $method) {
                    if ($method["type"] === "getter") {
                        if (isset($attributes[$method["type"]])) {
                            $currentMethod = $attributes[$method["type"]];
                            $found = false;
                            $value = null;
                            foreach ($this->___hydratorMethods as $checkMethod) {
                                if (str_starts_with($currentMethod, $checkMethod["prefix"])) {
                                    $value = $this->$currentMethod() ?? null;
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $value = $this->$name ?? null;
                            }
                            if ($withNullValue || !is_null($value)) {
                                $result[$name] = $value;
                            }
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }
}
