<?php


namespace ConvenientImmutability\Test;

use ConvenientImmutability\Test\Resources\Foo;

class ImmutableTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_allows_one_assignment_per_property()
    {
        $foo = new Foo();
        $foo->bar = 1;
        $foo->baz = 2;

        $this->assertSame(1, $foo->bar);
        $this->assertSame(2, $foo->baz);
    }

    /**
     * @test
     */
    public function it_fails_when_a_property_gets_reassigned()
    {
        $foo = new Foo();
        $foo->bar = 1;

        $this->assertSame(1, $foo->bar);

        $this->setExpectedException(\LogicException::class);
        $foo->bar = 2;
    }

    /**
     * @test
     */
    public function it_fails_to_assign_values_to_undefined_properties()
    {
        $foo = new Foo();

        $this->setExpectedException(\LogicException::class);
        $foo->bang = 1;
    }

    /**
     * @test
     */
    public function it_fails_to_retrieve_values_from_undefined_properties()
    {
        $foo = new Foo();

        $this->setExpectedException(\LogicException::class);
        $foo->bang;
    }

    /**
     * @test
     */
    public function it_returns_null_for_properties_that_have_no_assigned_value()
    {
        $foo = new Foo();

        $this->assertSame(null, $foo->bar);
    }

    /**
     * @test
     */
    public function it_returns_the_default_attribute_value_of_properties_that_have_no_assigned_value()
    {
        $foo = new Foo();

        $this->assertSame([], $foo->bazzes);
    }
}
