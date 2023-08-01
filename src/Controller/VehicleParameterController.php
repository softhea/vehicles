<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
use App\Request\CreateVehiclePropertyRequest;
use App\Request\EditVehiclePropertyRequest;
use App\Service\VehiclePropertyService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleParameterController extends AbstractController
{
    #[Route('/api/vehicles/{id}/properties', methods: ['POST'])]
    public function create(
        Vehicle $vehicle,
        Request $request, 
        VehiclePropertyService $vehiclePropertyService
    ): Response {
        try {
            $request = new CreateVehiclePropertyRequest($request->getContent());
            $vehicleProperty = $vehiclePropertyService->create(
                $vehicle, 
                $request->name, 
                $request->value
            );
        } catch (Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()], 
                Response::HTTP_BAD_REQUEST
            );
        }
        
        return $this->json($vehicleProperty, Response::HTTP_OK, [], ['groups' => 'api']);
    }

    #[Route('/api/vehicle-properties/{id}', methods: ['PATCH'])]
    public function edit(
        VehicleProperty $vehicleProperty, 
        Request $request, 
        VehiclePropertyService $vehiclePropertyService
    ): Response {
        try {
            $request = new EditVehiclePropertyRequest($request->getContent());
            $vehiclePropertyService->updateValue(
                $vehicleProperty, 
                $request->value
            );
        } catch (Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()], 
                Response::HTTP_BAD_REQUEST
            );
        }
        
        return $this->json($vehicleProperty, Response::HTTP_OK, [], ['groups' => 'api']);
    }
}
