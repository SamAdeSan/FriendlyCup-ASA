<?php

namespace App\Controller;

use App\Entity\PuntuajeEvento;
use App\Repository\TorneoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PuntuajeEventoController extends AbstractController
{
    #[Route('/crear/evento', name: 'crearevento', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $entityManager,TorneoRepository $torneoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $evento= new PuntuajeEvento();
        $evento->setPuntos($data['puntos']);
        $evento->setEvento($data['evento']);
        $torneo = $torneoRepository->find($data['torneo_id']);
        if (!$torneo) {
            return new JsonResponse(['error' => 'El torneo no existe'], 404);
        }
        $evento->setTorneo($torneo);
        
        $entityManager->persist($evento);
        $entityManager->flush();
        return new JsonResponse($evento->getId());
    }
}
