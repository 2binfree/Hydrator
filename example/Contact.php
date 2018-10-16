<?php

namespace ToBinFree\Hydrator;

require __DIR__.'/../vendor/autoload.php';

class Contact
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
     * @return $this
     */
    public function setName(string $name): Contact
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
     * @return $this
     */
    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

}


$user = new Contact();
$user->setEmail("eric@email.com");
$user->setName("Eric");

$data = [
    "name" => "Sonia",
    "email" => "sonia@email.com",
    "genre" => "female"
];

var_dump($user->toArray());
$user->hydrate($data);
var_dump($user->toArray());
