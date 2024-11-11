<?php

namespace App\Booking;

class Slot
{
    private array $reservations;
    private readonly int $slots;
    private \DateTimeImmutable $from;
    private \DateTimeImmutable $to;

    public function __construct(\DateTimeImmutable $from, \DateTimeImmutable $to, int $slots)
    {
        if ($from >= $to) {
            throw new \DomainException();
        }

        $this->reservations = [];
        $this->slots = $slots;
        $this->from = $from;
        $this->to = $to;
    }

    public function book(string $string, \DateTimeImmutable $dateOfBooking): void
    {
        if ($this->countReservations() === $this->slots) {
            throw new \DomainException();
        }

        if ($dateOfBooking->modify('+1 day') >= $this->from) {
            throw new \DomainException();
        }

        $this->reservations[] = $string;
    }

    public function countReservations(): int
    {
        return count($this->reservations);
    }
}