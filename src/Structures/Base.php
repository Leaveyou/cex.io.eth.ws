<?php

namespace Eth\Structures;

use InvalidArgumentException;
use JsonSerializable;

abstract class Base implements JsonSerializable
{
    protected $d4t4 = [];

    public function jsonSerialize()
    {
        return $this->d4t4;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        if ($name === "d4t4") {
            throw new InvalidArgumentException("Cannot use this name as key: " . $name);
        }
        $this->d4t4[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($name === "d4t4") {
            throw new InvalidArgumentException("What the hell do you need " . $name . " for?");
        }

        return $this->d4t4[$name];
    }
}