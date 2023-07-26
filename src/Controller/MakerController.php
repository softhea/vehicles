<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MakerController
{
    #[Route('/makers', methods: ['GET'])]
    public function list(): Response
    {
        return new JsonResponse([
            'test' => 123,
        ]);
    }
}
