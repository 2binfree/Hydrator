<?php

namespace ToBinFree\Test;

use ToBinFree\Hydrator\Hydrator;

class User
{
    use Hydrator;

    /** @var int */
    private $id;

    /**
     * @var string
     * @DataProperty
     */
    private $name;

    /**
     * @var string
     * @DataProperty
     */
    private $email;

    /**
     * @var string
     * @DataProperty
     */
    private $genre;

    public function __construct()
    {
        $this->genre = "male";
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
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
