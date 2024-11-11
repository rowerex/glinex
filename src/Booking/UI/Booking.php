<?php
declare(strict_types=1);

namespace App\Booking\UI;

use App\Booking\Slot;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route('/booking', name: 'booking')]
#[AsController]
final class Booking
{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function __invoke(): Response
    {
        $sessions = [
            new Slot(
                new \DateTimeImmutable('2025-01-01 12:00'),
                new \DateTimeImmutable('2025-01-01 14:00'),
                3,
            ),
            new Slot(
                new \DateTimeImmutable('2025-01-02 12:00'),
                new \DateTimeImmutable('2025-01-02 14:00'),
                3,
            ),
            new Slot(
                new \DateTimeImmutable('2025-01-02 14:00'),
                new \DateTimeImmutable('2025-01-02 16:00'),
                3,
            ),
        ];

        return new Response($this->twig->render('booking.html.twig', ['sessions' => $sessions]));
    }
}
