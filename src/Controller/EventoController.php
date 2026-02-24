<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\JugadorEvento;
use App\Repository\JugadoresRepository;
use App\Repository\TorneoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EventoController extends AbstractController
{
    #[Route('/crear/evento', name: 'crearevento', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $entityManager, TorneoRepository $torneoRepository, JugadoresRepository $jugadores): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $evento = new Evento();
        $evento->setPuntos($data['puntos']);
        $evento->setEvento($data['evento']);
        $torneo = $torneoRepository->find($data['torneo_id']);
        if (!$torneo) {
            return new JsonResponse(['error' => 'El torneo no existe'], 404);
        }
        $evento->setTorneo($torneo);
        $entityManager->persist($evento);
        foreach ($torneo->getEquipos() as $equipo) {
            foreach ($equipo->getJugadores() as $jugador) {
                $jugadorEvento = new JugadorEvento();
                $jugadorEvento->setEvento($evento);
                $jugadorEvento->setCantidad(0);
                $jugadorEvento->setJugador($jugador);
                $entityManager->persist($jugadorEvento);
            }
        }
        $entityManager->flush();
        return new JsonResponse($evento->getId());
    }

    #[Route('/evento/delete/{id}', name: 'eliminar_evento')]
    public function eliminar(Evento $evento, EntityManagerInterface $entityManager): Response
    {
        $torneoId = $evento->getTorneo()->getId();
        $entityManager->remove($evento);
        $entityManager->flush();

        return $this->redirectToRoute('torneo', ['id' => $torneoId]);
    }
}
