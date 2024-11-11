<?php

namespace App\Booking\Infrastructure;

use App\Booking\Slot;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\Uid\Ulid;

final class DbalSessionRepository implements SessionRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function get(Ulid $id): Slot
    {
        // TODO: Implement get() method.
    }

    public function add(Slot $slot): void
    {
        $this->connection->prepare()
            ->bindValue();
        $this->connection->exec(
            'INSERT INTO sessions (id, date_from, date_until, num_slots, reservations) VALUES (:id, :dateFrom, :dateUntil, :numSlots, :reservations)'
        );
    }

    public function save(): void
    {
        // TODO: Implement save() method.
    }
}