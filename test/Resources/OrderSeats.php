<?php

namespace ConvenientImmutability\Test\Resources;

use ConvenientImmutability\Immutable;

final class OrderSeats
{
    use Immutable;

    public $id;
    public $userId;
    public $seatNumbers = [];
}
