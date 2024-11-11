<?php

namespace App\Tests\Booking;

use App\Booking\Slot;
use PHPUnit\Framework\TestCase;

final class ExploratoryTest extends TestCase
{
    public function testSomeSlot()
    {
        $slot = new Slot(
            $this->dateFrom(),
            $this->dateUntil(),
            4
        );

        $slot->book('blah');
        $slot->book('gah');
        $slot->book('dah');
        $slot->book('mah');

        self::assertEquals(4, $slot->countReservations());
    }

    public function testCanNotBookOverLimit(): void
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 4);

        $this->expectException(\DomainException::class);

        $slot->book('blah');
        $slot->book('blah2');
        $slot->book('blah3');
        $slot->book('blah4');
        $slot->book('blah5');
    }

    public static function dateFrom(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2024-11-11 15:00');
    }

    public static function dateUntil(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2024-11-11 17:00');
    }
}