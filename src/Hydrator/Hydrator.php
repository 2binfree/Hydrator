<?php

namespace ToBinFree\Hydrator;

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

    /**
     * @throws \ReflectionException
     */
    private function initMethods()
    {
        $this->___hydratorObjectProperties = [];
        $thisClass = new \ReflectionClass($this);
        $properties = $thisClass->getProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            $comment = $property->getDocComment();
            if (false === strpos($name, $this->___hydratorFootPrint)) {
                $getMethod = "get" . ucfirst($name);
                $setMethod = "set" . ucfirst($name);
                if (false !== strpos($comment, "@DataProperty")) {
                    $this->___hydratorObjectProperties[$name]["type"] = "@DataProperty";
                } else {
                    $this->___hydratorObjectProperties[$name]["type"] = "undefined";
                }
                if ($thisClass->hasMethod($getMethod)) {
                    $this->___hydratorObjectProperties[$name]["get"] = $getMethod;
                } else {
                    if (false === $this->___hydratorAccessorOnly) {
                        $this->___hydratorObjectProperties[$name]["get"] = $name;
                    }
                }
                if ($thisClass->hasMethod($setMethod)) {
                    $this->___hydratorObjectProperties[$name]["set"] = $setMethod;
                } else {
                    if (false === $this->___hydratorMutatorOnly) {
                        $this->___hydratorObjectProperties[$name]["set"] = $name;
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
     * @throws \ReflectionException
     */
    public function hydrate(array $data):void
    {
        if (empty($this->___hydratorObjectProperties)) {
            $this->initMethods();
        }
        foreach ($data as $key => $value) {
            if (isset($this->___hydratorObjectProperties[$key]["set"])) {
                $method = $this->___hydratorObjectProperties[$key]["set"];
                if ("set" === substr($method, 0, 3)) {
                    $this->$method($value);
                } else {
                    $this->$method = $value;
                }
            }
        }
    }

    /**
     * @param bool $dataOnly
     * @return array
     * @throws \ReflectionException
     */
    public function toArray(bool $dataOnly = false):array
    {
        $result = [];
        if (empty($this->___hydratorObjectProperties)) {
            $this->initMethods();
        }
        foreach ($this->___hydratorObjectProperties as $name => $attributes) {
            if (false === $dataOnly || "@DataProperty" === $attributes["type"]) {
                if (isset($attributes["get"])) {
                    $method = $attributes["get"];
                    if ("get" === substr($method, 0, 3)) {
                        $result[$name] = $this->$method();
                    } else {
                        $result[$name] = $this->$method;
                    }
                }
            }
        }
        return $result;
    }
}
