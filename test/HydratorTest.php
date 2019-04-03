<?php

use PHPUnit\Framework\TestCase;
use ToBinFree\Test\User;

class HydratorTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testToArray()
    {
        $user = new User();
        $user->setId(1);
        $user->setName("Jean");
        $user->setEmail("jean@email.com");
        $this->assertEquals(
            [
                "id"    => 1,
                "name"  => "Jean",
                "email" => "jean@email.com",
                "genre" => "male",
                "type"  => "contact",
                "cardId"=> null,
            ],
            $user->toArray()
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testToArrayData()
    {
        $user = new User();
        $user->setId(1);
        $user->setName("Jean");
        $user->setEmail("jean@email.com");
        $this->assertEquals(
            [
                "name"  => "Jean",
                "email" => "jean@email.com",
                "genre" => "male",
                "type"  => "contact",
            ],
            $user->toArray(true)
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testToArrayStrict()
    {
        $user = new User();
        $user->setAccessorOnly(true);
        $user->setId(1);
        $user->setName("Jean");
        $user->setEmail("jean@email.com");
        $this->assertEquals(
            [
                "id"    => 1,
                "name"  => "Jean",
                "email" => "jean@email.com",
                "type"  => "contact",
                "cardId"=> null,
            ],
            $user->toArray()
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testHydrator()
    {
        $user = new User();
        $user->hydrate([
            "id"    => 1,
            "name"  => "Sonia",
            "email" => "sonia@email.com",
            "genre" => "female",
            "type"  => "contact",
            "cardId"=> 555,
        ]);
        $this->assertEquals(
            [
                "id"    => 1,
                "name"  => "Sonia",
                "email" => "sonia@email.com",
                "genre" => "female",
                "type"  => "contact",
                "cardId"=> 555,
            ],
            $user->toArray()
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testHydratorStrict()
    {
        $user = new User();
        $user->setMutatorOnly(true);
        $user->hydrate([
            "id"    => 1,
            "name"  => "Sonia",
            "email" => "sonia@email.com",
            "genre" => "female",
            "type"  => "contact",
        ]);
        $this->assertEquals(
            [
                "id"    => 1,
                "name"  => "Sonia",
                "email" => "sonia@email.com",
                "genre" => "male",
                "type"  => "contact",
                "cardId"=> null,
            ],
            $user->toArray()
        );
    }
}
