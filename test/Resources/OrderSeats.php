<?php

namespace ConvenientImmutability\Test\Resources;

use ConvenientImmutability\Immutable;

class OrderSeats
{
    use Immutable;

    public $id;
    public $userId;
    public $seatNumbers = [];
}
