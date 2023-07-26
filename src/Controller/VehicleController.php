<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController
{
    #[Route('/vehicles/{id}', methods: ['GET'])]
    public function show(int $id): Response
    {
        return new JsonResponse([
            'test' => 123,
        ]);
    }

    #[Route('/vehicles/{id}', methods: ['PATCH'])]
    public function edit(int $id): Response
    {
        return new JsonResponse([
            'updated' => 123,
        ]);
    }
}
