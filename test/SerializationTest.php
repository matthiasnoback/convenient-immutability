<?php


namespace ConvenientImmutability\Test;

use ConvenientImmutability\Test\Resources\Foo;

class SerializationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_be_same_after_serialization()
    {
        $foo = new Foo();
        $foo->bar = 1;
        $foo->baz = 2;

        $serializedValue = serialize($foo);
        $deSerializedValue = unserialize($serializedValue);

        $this->assertSame($deSerializedValue->bar, $foo->bar);
        $this->assertSame($deSerializedValue->baz, $foo->baz);
    }
}
