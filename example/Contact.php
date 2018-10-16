<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

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
    "name" => "toto",
    "email" => "toto@titi.com",
    "genre" => "female"
];

var_dump($user->toArray());
$user->hydrate($data);
var_dump($user->toArray());
