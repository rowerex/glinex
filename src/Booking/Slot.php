<?php

namespace App\Booking;

use Symfony\Component\Uid\Ulid;

class Slot
{
    private array $reservations;
    public readonly Ulid $id;
    public readonly int $slots;
    public readonly \DateTimeImmutable $from;
    public readonly \DateTimeImmutable $to;

    public function __construct(Ulid $id, \DateTimeImmutable $from, \DateTimeImmutable $to, int $slots)
    {
        if ($from >= $to) {
            throw new \DomainException();
        }

        $this->id = $id;
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

    public function isOpenForBooking(\DateTimeImmutable $date): bool
    {
        return $this->countReservations() < $this->slots && !$this->isAfterReservationsCutoff($date);
    }
    public function isOpenForBookingNow(): bool
    {
        return $this->isOpenForBooking(new \DateTimeImmutable());
    }
}