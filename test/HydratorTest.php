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
                "genre" => "male"
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
                "genre" => "male"
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
            "genre" => "female"
        ]);
        $this->assertEquals(
            [
                "id"    => 1,
                "name"  => "Sonia",
                "email" => "sonia@email.com",
                "genre" => "female"
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
            "genre" => "female"
        ]);
        $this->assertEquals(
            [
                "id"    => 1,
                "name"  => "Sonia",
                "email" => "sonia@email.com",
                "genre" => "male"
            ],
            $user->toArray()
        );
    }
}
