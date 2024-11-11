<?php

namespace App\Tests\Booking;

use App\Booking\Slot;
use PHPUnit\Framework\TestCase;

final class SlotReservationsTest extends TestCase
{
    public function testCanBookASlot()
    {
        $slot = new Slot(
            $this->dateFrom(),
            $this->dateUntil(),
            4
        );

        $slot->book('blah', self::validDateForBooking());
        $slot->book('gah', self::validDateForBooking());
        $slot->book('dah', self::validDateForBooking());
        $slot->book('mah', self::validDateForBooking());

        self::assertEquals(4, $slot->countReservations());
    }

    public function testCanNotBookOverLimit(): void
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 4);

        $this->expectException(\DomainException::class);

        $slot->book('blah', self::validDateForBooking());
        $slot->book('blah2', self::validDateForBooking());
        $slot->book('blah3', self::validDateForBooking());
        $slot->book('blah4', self::validDateForBooking());
        $slot->book('blah5', self::validDateForBooking());
    }

    public function testCanNotBookLate(): void
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 1);

        $this->expectException(\DomainException::class);

        $slot->book('blah', self::dateTooLateForBooking());
    }

    public function testCanCancelBooking(): void
    {
        $slot = new Slot(
            $this->dateFrom(),
            $this->dateUntil(),
            4
        );

        $slot->book('blah', self::validDateForBooking());
        $slot->book('gah', self::validDateForBooking());

        $slot->cancelBooking('gah', self::latestValidDateForCancel());

        self::assertEquals(1, $slot->countReservations());
    }

    public function testCanNotCancelBookingTooLate(): void
    {
        $slot = new Slot(
            $this->dateFrom(),
            $this->dateUntil(),
            4
        );

        $slot->book('blah', self::validDateForBooking());

        self::expectException(\DomainException::class);

        $slot->cancelBooking('gah', self::dateTooLateForBooking());
    }

    public function testSlotCannotEndBeforeItsBeginning()
    {
        self::expectException(\DomainException::class);
        new Slot(self::dateUntil(), self::dateFrom(), 0);
    }

    public function testSlotMustHaveSomeDuration()
    {
        self::expectException(\DomainException::class);
        new Slot(self::dateFrom(), self::dateFrom(), 0);
    }

    public function testIsOpenForBooking(): void
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 1);
        self::assertTrue($slot->isOpenForBooking(self::validDateForBooking()));

        $slot = new Slot(self::dateFrom(), self::dateUntil(), 3);
        $slot->book('meh', self::validDateForBooking());
        $slot->book('deh', self::validDateForBooking());
        self::assertTrue($slot->isOpenForBooking(self::validDateForBooking()));
    }

    public function testIsClosedForBookingAfterCutoffDate(): void
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 1);
        self::assertFalse($slot->isOpenForBooking(self::dateTooLateForBooking()));
    }

    public function testIsClosedForBookingWhenSlotsFull(): void
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 1);

        $slot->book('meh', self::validDateForBooking());
        self::assertFalse($slot->isOpenForBooking(self::validDateForBooking()));

        $slot = new Slot(self::dateFrom(), self::dateUntil(), 3);

        $slot->book('meh', self::validDateForBooking());
        $slot->book('deh', self::validDateForBooking());
        $slot->book('beh', self::validDateForBooking());
        self::assertFalse($slot->isOpenForBooking(self::validDateForBooking()));
    }

    public function testIsClosedForBookingAfterCutoffAndFullyBooked()
    {
        $slot = new Slot(self::dateFrom(), self::dateUntil(), 3);

        $slot->book('meh', self::validDateForBooking());
        $slot->book('deh', self::validDateForBooking());
        $slot->book('beh', self::validDateForBooking());
        self::assertFalse($slot->isOpenForBooking(self::dateTooLateForBooking()));
    }

    public static function dateFrom(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2024-11-11 15:00');
    }

    public static function dateUntil(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2024-11-11 17:00');
    }

    private static function latestValidDateForCancel()
    {
        return self::latestValidDateForBooking();
    }

    private static function dateTooLateForBooking()
    {
        return new \DateTimeImmutable('2024-11-10 15:00:00');
    }

    private static function latestValidDateForBooking()
    {
        return new \DateTimeImmutable('2024-11-10 14:59:59');
    }

    private static function validDateForBooking()
    {
        return new \DateTimeImmutable('2024-11-07 20:00:00');
    }
}