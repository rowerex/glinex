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

        if ($this->isAfterReservationsCutoff($dateOfBooking)) {
            throw new \DomainException();
        }

        $this->reservations[] = $string;
    }

    public function countReservations(): int
    {
        return count($this->reservations);
    }

    public function cancelBooking(string $string, \DateTimeImmutable $now)
    {
        if ($this->isAfterReservationsCutoff($now)) {
            throw new \DomainException();
        }

        $this->reservations = array_filter($this->reservations, function ($v) use ($string) { return $v === $string; });
    }

    public function isAfterReservationsCutoff(\DateTimeImmutable $date): bool
    {
        return $date->modify('+1 day') >= $this->from;
    }
}