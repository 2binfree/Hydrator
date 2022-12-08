<?php

namespace ToBinFree\Test;

use ToBinFree\Hydrator\DataProperty;
use ToBinFree\Hydrator\Hydrator;

class User extends BaseUser
{
    use Hydrator;

    private ?int $id;
    #[DataProperty]
    private string $name;
    #[DataProperty]
    private string $email;
    #[DataProperty]
    private string $genre;
    #[DataProperty]
    private bool $decisionMaker;

    public function __construct()
    {
        parent::__construct();
        $this->genre = "male";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function isDecisionMaker(): ?bool
    {
        return $this->decisionMaker;
    }

    public function setDecisionMaker(bool $decisionMaker): BaseUser
    {
        $this->decisionMaker = $decisionMaker;
        return $this;
    }
}
