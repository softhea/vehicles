<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\MakerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class MakerController extends AbstractController
{
    #[Route('/api/makers', methods: ['GET'])]
    public function list(Request $request, MakerService $makerService): Response
    {
        $typeId = null !== $request->query->get('type_id') 
            ? (int)$request->query->get('type_id')
            : null;
        
        $makers = $makerService->list($typeId);

        return $this->json($makers, Response::HTTP_OK, [], ['groups' => ['api']]);
    }
}
