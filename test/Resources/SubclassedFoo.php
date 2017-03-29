<?php
declare(strict_types = 1);

namespace ConvenientImmutability\Test\Resources;

final class SubclassedFoo extends Foo
{
    public function __construct()
    {
        parent::__construct();
    }
}
