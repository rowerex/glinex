<?php
declare(strict_types=1);

namespace App\Booking\UI;

use App\Booking\Infrastructure\SessionRepository;
use App\Booking\Slot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;
use Twig\Environment;

#[Route('/booki/{sessionId}', name: 'bookForASession', requirements: ['sessionId' => '[a-zA-Z0-9\-]+'], methods: ['POST'])]
#[AsController]
final class BookForASession
{
    public function __construct(private readonly Environment $twig, private readonly SessionRepository $repository)
    {
    }

    public function __invoke(string $sessionId, Request $request): Response
    {
        $email = $request->get('email');

        if (!str_contains($email, '@')) {
            throw new \InvalidArgumentException();
        }

        $session = $this->repository->get(Ulid::fromString($sessionId));
        $session->book('blag', new \DateTimeImmutable());
        $this->repository->save();

        return new Response($this->twig->render('booking.html.twig'));
    }
}
