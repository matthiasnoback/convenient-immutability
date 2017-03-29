<?php

namespace ConvenientImmutability\Test;

use ConvenientImmutability\Test\Resources\OrderSeats;
use ConvenientImmutability\Test\Resources\OrderSeatsFormType;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\Test\TypeTestCase;

class FormIntegrationTest extends TypeTestCase
{
    /**
     * @test
     */
    public function it_works_with_a_standard_use_case_for_command_objects()
    {
        $id = Uuid::uuid4();
        $form = $this->factory->create(new OrderSeatsFormType());
        $form->submit([
            'userId' => 1,
            'seatNumbers' => ['1', '2']
        ]);
        $command = $form->getData();
        $command->id = $id;

        $expected = new OrderSeats();
        $expected->id = $id;
        $expected->userId = 1;
        $expected->seatNumbers = [1, 2];
        $this->assertEquals($expected, $command);
    }
}
