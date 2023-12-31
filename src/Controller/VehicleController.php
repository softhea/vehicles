<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    #[Route('/api/vehicles/{id}', methods: ['GET'])]
    public function show(Vehicle $vehicle): Response
    {
        return $this->json($vehicle, Response::HTTP_OK, [], ['groups' => ['api']]);
    }
}
