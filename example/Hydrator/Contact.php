<?php

namespace ToBinFree\Hydrator;

use Exception;
use ReflectionException;

require __DIR__.'/../../vendor/autoload.php';

class Contact
{
    use Hydrator;

    private int $id;

    #[DataProperty]
    private string $name;

    #[DataProperty]
    private string $email;

    #[DataProperty]
    private string $genre;

    public function __construct()
    {
        $this->genre = "male";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

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

try {
    var_dump($user->toArray());
    $user->hydrate($data);
    var_dump($user->toArray());
} catch (ReflectionException|Exception $e) {
    echo $e->getMessage();
}
