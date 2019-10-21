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
        $data = [
            "id"    => 1,
            "name"  => "Jean",
            "email" => "jean@email.com",
            "genre" => "male",
            "type"  => "contact",
            "cardId"=> null,
        ];
        $user = new User();
        $user->setId(1);
        $user->setName("Jean");
        $user->setEmail("jean@email.com");
        $this->assertEquals($data, $user->toArray());
        $this->assertNotEquals($data, $user->toArray(false, false));
    }

    /**
     * @throws ReflectionException
     */
    public function testToArrayData()
    {
        $data = [
            "name"  => "Jean",
            "email" => "jean@email.com",
            "genre" => "male",
            "type"  => "contact",
            "cardId"=> null,
        ];
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
        $data = [
            "id"    => 1,
            "name"  => "Jean",
            "email" => "jean@email.com",
            "type"  => "contact",
            "cardId"=> null,
        ];
        $user = new User();
        $user->setAccessorOnly(true);
        $user->setId(1);
        $user->setName("Jean");
        $user->setEmail("jean@email.com");
        $this->assertEquals($data, $user->toArray());
        $this->assertEquals($data, $user->toArray(), false, false);
    }

    /**
     * @throws ReflectionException
     */
    public function testHydrator()
    {
        $data = [
            "id"    => 1,
            "name"  => "Sonia",
            "email" => "sonia@email.com",
            "genre" => "female",
            "type"  => "contact",
            "cardId"=> null,
        ];
        $user = new User();
        $user->hydrate($data);
        $this->assertEquals($data, $user->toArray());
        $this->assertNotEquals($data, $user->toArray(false, false));
    }

    /**
     * @throws ReflectionException
     */
    public function testHydratorStrict()
    {
        $data = [
            "id"    => 1,
            "name"  => "Sonia",
            "email" => "sonia@email.com",
            "genre" => "male",
            "type"  => "contact",
            "cardId"=> null,
        ];
        $user = new User();
        $user->setMutatorOnly(true);
        $user->hydrate([
            "id"    => 1,
            "name"  => "Sonia",
            "email" => "sonia@email.com",
            "genre" => "female",
            "type"  => "contact",
        ]);
        $this->assertEquals($data, $user->toArray());
        $this->assertNotEquals($data, $user->toArray(false, false));
    }
}
