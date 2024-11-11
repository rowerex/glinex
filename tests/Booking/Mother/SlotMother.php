<?php

namespace App\Tests\Booking\Mother;

use App\Booking\Slot;
use Symfony\Component\Uid\Ulid;

class SlotMother
{
    public static function withNumberOfSlots(int $int): Slot
    {
        return new Slot(Ulid::fromString(Ulid::generate()), new \DateTimeImmutable('2025-01-01'), new \DateTimeImmutable('2025-01-02'), $int);
    }

    public static function withDates(\DateTimeImmutable $dateFrom, \DateTimeImmutable $dateUntil)
    {
        return new Slot(Ulid::fromString(Ulid::generate()), $dateFrom, $dateUntil, 999);
    }
}