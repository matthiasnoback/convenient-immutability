<?php


namespace ConvenientImmutability\Test;

use ConvenientImmutability\Test\Resources\Foo;
use ConvenientImmutability\Test\Resources\SubclassedFoo;
use LogicException;
use PHPUnit\Framework\TestCase;

class ImmutableTraitTest extends TestCase
{
    /**
     * @return array
     */
    public function objectProvider()
    {
        $foo = new Foo();

        $unserializedFoo = unserialize(serialize($foo));

        $fooWithCustomConstructor = new SubclassedFoo();

        return [
            [$foo],
            [$unserializedFoo],
            [$fooWithCustomConstructor]
        ];
    }

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

        $this->expectException(LogicException::class);
        $foo->bar = 2;
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_fails_to_assign_values_to_undefined_properties(Foo $foo)
    {
        $this->expectException(LogicException::class);
        $foo->bang = 1;
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_fails_to_retrieve_values_from_undefined_properties(Foo $foo)
    {
        $this->expectException(LogicException::class);
        $foo->bang;
    }

    /**
     * @test
     * @dataProvider objectProvider
     */
    public function it_returns_null_for_properties_that_have_no_assigned_value(Foo $foo)
    {
        $this->assertSame(null, $foo->bar);
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
     * @test
     * @dataProvider objectProvider
     */
    public function it_should_have_the_same_values_after_deserialization(Foo $foo)
    {
        $foo->bar = 'bar';
        $foo->baz = 1;
        $foo->bazzes = [1, 2, 3, 4];

        /** @var Foo $deSerialized */
        $deSerialized = unserialize(serialize($foo));

        $this->assertSame($foo->bar, $deSerialized->bar);
        $this->assertSame($foo->baz, $deSerialized->baz);
        $this->assertSame($foo->bazzes, $deSerialized->bazzes);
    }
}
