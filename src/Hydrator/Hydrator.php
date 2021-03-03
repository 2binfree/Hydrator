<?php

namespace ToBinFree\Hydrator;

use ReflectionClass;
use ReflectionException;

trait Hydrator
{
    /** @var string */
    private $___hydratorFootPrint = "___hydrator";

    /** @var array */
    private $___hydratorObjectProperties = [];

    /** @var bool */
    private $___hydratorAccessorOnly = false;

    /** @var bool */
    private $___hydratorMutatorOnly = false;

    /** @var array */
    private $___hydratorMethods = [
        ["type" => "getter", "prefix" => "get"],
        ["type" => "getter", "prefix" => "is"],
        ["type" => "setter", "prefix" => "set"],
    ];

    /**
     * @throws ReflectionException
     */
    private function initMethods()
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
            $comment = $property->getDocComment();
            if (false === strpos($name, $this->___hydratorFootPrint)) {
                if (false !== strpos($comment, "@DataProperty")) {
                    $this->___hydratorObjectProperties[$name]["type"] = "@DataProperty";
                } else {
                    $this->___hydratorObjectProperties[$name]["type"] = "undefined";
                }
                foreach ($this->___hydratorMethods as $method) {
                    $currentMethod = $method["prefix"] . ucfirst($name);
                    if ($thisClass->hasMethod($currentMethod)) {
                        $this->___hydratorObjectProperties[$name][$method["type"]] = $currentMethod;
                        break;
                    }
                }
                if (!isset($this->___hydratorObjectProperties[$name]["getter"])) {
                    if (false === $this->___hydratorAccessorOnly) {
                        $this->___hydratorObjectProperties[$name]["getter"] = $name;
                    }
                }
                if (!isset($this->___hydratorObjectProperties[$name]["setter"])) {
                    if (false === $this->___hydratorAccessorOnly) {
                        $this->___hydratorObjectProperties[$name]["setter"] = $name;
                    }
                }
            }
        }
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setMutatorOnly(bool $value)
    {
        $this->___hydratorMutatorOnly = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setAccessorOnly(bool $value)
    {
        $this->___hydratorAccessorOnly = $value;
        return $this;
    }

    /**
     * @param array $data
     * @param bool $withNullValue
     * @throws ReflectionException
     */
    public function hydrate(array $data, $withNullValue = true):void
    {
        if (empty($this->___hydratorObjectProperties)) {
            $this->initMethods();
        }
        foreach ($data as $key => $value) {
            if (true === $withNullValue || (false === $withNullValue && !is_null($value))) {
                foreach ($this->___hydratorMethods as $method) {
                    if ($method["type"] === "setter") {
                        if (isset($this->___hydratorObjectProperties[$key][$method["type"]])) {
                            $currentMethod = $this->___hydratorObjectProperties[$key][$method["type"]];
                            if ($method["prefix"] === substr($currentMethod, 0, strlen($method["prefix"]))) {
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
    public function toArray(bool $dataOnly = false, $withNullValue = true):array
    {
        $result = [];
        if (empty($this->___hydratorObjectProperties)) {
            $this->initMethods();
        }
        foreach ($this->___hydratorObjectProperties as $name => $attributes) {
            if (false === $dataOnly || "@DataProperty" === $attributes["type"]) {
                foreach ($this->___hydratorMethods as $method) {
                    if ($method["type"] === "getter") {
                        if (isset($attributes[$method["type"]])) {
                            $currentMethod = $attributes[$method["type"]];
                            $found = false;
                            $value = null;
                            foreach ($this->___hydratorMethods as $checkMethod) {
                                if ($checkMethod["prefix"] === substr($currentMethod, 0, strlen($checkMethod["prefix"]))) {
                                    $value = isset($this->$name) ? $this->$currentMethod() : null;
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $value = (isset($this->$name)) ? $this->$currentMethod : null;
                            }
                            if (true === $withNullValue || (false === $withNullValue && !is_null($value))) {
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
