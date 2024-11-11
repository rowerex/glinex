<?php

namespace App\Tests\Booking;

use App\Booking\Slot;
use PHPUnit\Framework\TestCase;

final class ExploratoryTest extends TestCase
{
    public function testSomeSlot()
    {
        $slot = new Slot(
            new \DateTimeImmutable('2024-11-11 15:00'),
            new \DateTimeImmutable('2024-11-11 17:00'),
            8
        );

        $slot->book('blah');
        $slot->book('gah');
        $slot->book('dah');
        $slot->book('mah');

        $slot->book('wah');
        $slot->book('mwah');
        $slot->book('bmwah');
        $slot->book('dmwah');

        self::assertEquals(8, $slot->countReservations());
    }
}