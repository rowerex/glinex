<?php

namespace App\Booking\Infrastructure;

use App\Booking\Slot;
use Symfony\Component\Uid\Ulid;

interface SessionRepository
{
    public function get(Ulid $id): Slot;
    public function add(Slot $slot): void;
    public function save(): void;
}