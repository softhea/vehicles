<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\MakerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MakerController extends AbstractController
{
    #[Route('/api/makers', methods: ['GET'])]
    public function list(MakerRepository $makerRepository): Response
    {
        $makers = $makerRepository->findAll();

        return $this->json($makers, Response::HTTP_OK, [], ['groups' => ['api']]);
    }
}
