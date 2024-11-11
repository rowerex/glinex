<?php
declare(strict_types=1);

namespace App\Booking\UI;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/booking')]
#[AsController]
final class Booking
{
    public function __invoke(): Response
    {
        return new Response('<html><body><h1>Booking</h1></body></html>');
    }
}
