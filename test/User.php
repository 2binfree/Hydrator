<?php

namespace ToBinFree\Test;

use ToBinFree\Hydrator\Hydrator;

class User
{
    use Hydrator;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $genre;

    public function __construct()
    {
        $this->genre = "male";
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
}
