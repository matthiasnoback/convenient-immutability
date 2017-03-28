<?php


namespace ConvenientImmutability\Test;

use ConvenientImmutability\Test\Resources\Foo;

class ImmutableTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_allows_one_assignment_per_property(Foo $foo)
    {
        $foo->bar = 1;
        $foo->baz = 2;

        $this->assertSame(1, $foo->bar);
        $this->assertSame(2, $foo->baz);
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_fails_when_a_property_gets_reassigned(Foo $foo)
    {
        $foo->bar = 1;

        $this->assertSame(1, $foo->bar);

        $this->setExpectedException(\LogicException::class);
        $foo->bar = 2;
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_fails_to_assign_values_to_undefined_properties(Foo $foo)
    {
        $this->setExpectedException(\LogicException::class);
        $foo->bang = 1;
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_fails_to_retrieve_values_from_undefined_properties(Foo $foo)
    {
        $this->setExpectedException(\LogicException::class);
        $foo->bang;
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_returns_null_for_properties_that_have_no_assigned_value(Foo $foo)
    {
        $this->assertNull($foo->bar);
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_returns_the_default_attribute_value_of_properties_that_have_no_assigned_value(Foo $foo)
    {
        $this->assertSame([], $foo->bazzes);
    }

    /**
     * @return array
     */
    public function objectProvider()
    {
        $foo = new Foo();

        $unserializedFoo = unserialize(serialize($foo));

        return [
            [$foo],
            [$unserializedFoo]
        ];
    }
}
