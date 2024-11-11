<?php

namespace App\Booking;

class Slot
{
    private array $reservations;
    private readonly int $slots;

    public function __construct(\DateTimeImmutable $from, \DateTimeImmutable $to, int $slots)
    {
        if ($from >= $to) {
            throw new \DomainException();
        }

        $this->reservations = [];
        $this->slots = $slots;
    }

    public function book(string $string): void
    {
        if ($this->countReservations() === $this->slots) {
            throw new \DomainException();
        }

        $this->reservations[] = $string;
    }

    public function countReservations(): int
    {
        return count($this->reservations);
    }
}