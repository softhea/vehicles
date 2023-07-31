<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
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
        $request = json_decode($request->getContent(), true);
        if (!array_key_exists('value', (array)$request)) {
            return $this->json(
                ['error' => '\'value\' parameter missing from Request!'], 
                Response::HTTP_BAD_REQUEST
            );
        }

        $value = null === $request['value'] ? null : (string)$request['value'];
        $name = 'color';

        try {
            $vehicleProperty = $vehiclePropertyService->create($vehicle, $name, $value);
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
        $request = json_decode($request->getContent(), true);
        if (!array_key_exists('value', (array)$request)) {
            return $this->json(
                ['error' => '\'value\' parameter missing from Request!'], 
                Response::HTTP_BAD_REQUEST
            );
        }

        $value = null === $request['value'] ? null : (string)$request['value'];

        try {
            $vehiclePropertyService->updateValue($vehicleProperty, $value);
        } catch (Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()], 
                Response::HTTP_BAD_REQUEST
            );
        }
        
        return $this->json($vehicleProperty, Response::HTTP_OK, [], ['groups' => 'api']);
    }
}
