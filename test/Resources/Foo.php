<?php

namespace ConvenientImmutability\Test\Resources;

use ConvenientImmutability\Immutable;

class Foo
{
    use Immutable;

    public $bar;
    public $baz;
    public $bazzes = [];
}
