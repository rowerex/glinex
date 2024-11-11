<?php

namespace App\Booking;

class Slot
{
    private array $reservations;
    public function __construct(\DateTimeImmutable $param, \DateTimeImmutable $param1, int $int)
    {
        $this->reservations = [];
    }

    public function book(string $string): void
    {
        $this->reservations[] = $string;
    }

    public function countReservations(): int
    {
        return count($this->reservations);
    }
}