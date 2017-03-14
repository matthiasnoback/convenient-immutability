<?php


namespace ConvenientImmutability\Test;

use ConvenientImmutability\Test\Resources\Foo;

class SerializationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_allows_one_assignment_per_property()
    {
        $foo = new Foo();
        $foo->bar = 1;
        $foo->baz = 2;

        $newFoo = unserialize(serialize($foo));

        $this->assertSame(1, $newFoo->bar);
        $this->assertSame(2, $newFoo->baz);
    }

    /**
     * @test
     */
    public function it_fails_when_a_property_gets_reassigned()
    {
        $foo = new Foo();
        $foo->bar = 1;
        $newFoo = unserialize(serialize($foo));

        $this->assertSame(1, $newFoo->bar);

        $this->setExpectedException(\LogicException::class);
        $newFoo->bar = 2;
    }

    /**
     * @test
     */
    public function it_fails_to_assign_values_to_undefined_properties()
    {
        $foo = new Foo();
        $newFoo = unserialize(serialize($foo));

        $this->setExpectedException(\LogicException::class);
        $newFoo->bang = 1;
    }

    /**
     * @test
     */
    public function it_fails_to_retrieve_values_from_undefined_properties()
    {
        $foo = new Foo();
        $newFoo = unserialize(serialize($foo));

        $this->setExpectedException(\LogicException::class);
        $newFoo->bang;
    }

    /**
     * @test
     */
    public function it_returns_null_for_properties_that_have_no_assigned_value()
    {
        $foo = new Foo();
        $newFoo = unserialize(serialize($foo));

        $this->assertSame(null, $newFoo->bar);
    }

    /**
     * @test
     */
    public function it_returns_the_default_attribute_value_of_properties_that_have_no_assigned_value()
    {
        $foo = new Foo();
        $newFoo = unserialize(serialize($foo));

        $this->assertSame([], $newFoo->bazzes);
    }
}
