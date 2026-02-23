<?php

namespace App\Controller;

use App\Entity\Disputas;
use App\Repository\DisputasRepository;
use App\Repository\EquiposRepository;
use App\Repository\TorneoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Torneo;
use App\Repository\JugadorEventoRepository;
use App\Repository\EventoRepository;
use App\Repository\JugadoresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DisputasController extends AbstractController
{
    #[Route('/anadircantidad/{jugador_id}/{evento_id}/{cantidad}', name: 'anadircantidad', methods: ['POST'])]
    public function anadircantidad(
        int $jugador_id,
        int $evento_id,
        int $cantidad,
        EntityManagerInterface $entityManager,
        JugadorEventoRepository $jugadoreventoRepository,
        JugadoresRepository $jugadoresRepository,
        EventoRepository $eventoRepository
    ): JsonResponse {
        $jugador = $jugadoresRepository->find($jugador_id);
        $evento = $eventoRepository->find($evento_id);
        // Buscamos si ya existe la relación Jugador-Evento
        $jugadorevento = $jugadoreventoRepository->findOneBy([
            'jugador' => $jugador,
            'evento' => $evento
        ]);
        $jugadorevento->setCantidad($jugadorevento->getCantidad() + $cantidad);
        $puntos = $cantidad * $evento->getPuntos();
        $jugador->setEstadisticas($jugador->getEstadisticas() + $puntos);
        foreach ($jugador->getEquipoFantasies() as $fantasy) {
            $fantasy->setPuntos($fantasy->getPuntos() + $puntos);
            $entityManager->persist($fantasy);
        }

        $entityManager->persist($jugadorevento);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'id' => $jugadorevento->getId()]);
    }
    #[Route('/disputa/crear', name: 'creardisputas', methods: ['POST'])]
    public function crearDisputas(Request $request, EntityManagerInterface $entityManager, EquiposRepository $equiposRepository, TorneoRepository $torneoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $disputa = new Disputas();
        $disputa->setResultado('n-n');
        $equipo1 = $equiposRepository->find($data['equipo1_id']);
        $equipo2 = $equiposRepository->find($data['equipo2_id']);
        $torneo = $torneoRepository->find($data['torneo_id']) ?? 'aaa';
        $disputa->setEquipo1($equipo1);
        $disputa->setEquipo2($equipo2);
        $disputa->setTorneo($torneo);
        $entityManager->persist($disputa);
        $entityManager->flush();
        return new JsonResponse($disputa->getId());
    }
    #[Route('/disputa/{id}/modificar', name: 'modificardisputas', methods: ['POST'])]
    public function modificarDisputas(Request $request, EntityManagerInterface $entityManager, DisputasRepository $disputasRepository, EquiposRepository $equiposRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $disputa = $disputasRepository->find($id);
        $disputa->setResultado($data['resultado']);
        if ($data['ganador_id']) {
            $equipoGanador = $equiposRepository->find($data['ganador_id']);
            $disputa->setGanador($equipoGanador);
        } else {
            $disputa->setGanador(null);
        }
        $this->calculodepuntos($disputa->getTorneo(), $entityManager);
        $entityManager->flush();
        return new JsonResponse($disputa->getId());
    }
    #[Route('/disputa/{id}/eliminar', name: 'eliminardisputas')]
    public function eliminarDisputas(EntityManagerInterface $entityManager, DisputasRepository $disputasRepository, int $id): Response
    {
        $disputa = $disputasRepository->find($id);
        $torneoId = $disputa->getTorneo()->getId();
        $entityManager->remove($disputa);
        $entityManager->flush();
        $this->calculodepuntos($disputa->getTorneo(), $entityManager);
        return $this->redirectToRoute('torneo', ['id' => $torneoId]);
    }
    private function calculodepuntos(Torneo $torneo, EntityManagerInterface $entityManager)
    {
        $equipos = $torneo->getEquipos();
        foreach ($equipos as $equipo) {
            $equipo->setPuntos(0);
            $disputas = $equipo->getTodasLasDisputas();
            foreach ($disputas as $disputa) {
                if ($disputa->getGanador() == $equipo) {
                    $equipo->setPuntos($equipo->getPuntos() + 3);
                } elseif ($disputa->getResultado() != 'n-n' && $disputa->getGanador() == null) {
                    $equipo->setPuntos($equipo->getPuntos() + 1);
                }
            }
            $entityManager->persist($equipo);
        }
        $entityManager->flush();
    }
    #[Route('/disputa/{id}', name: 'disputa')]
    public function disputaindex(DisputasRepository $disputasRepository, EventoRepository $eventoRepository, int $id): Response
    {
        // Buscamos la disputa específica por su ID
        $disputa = $disputasRepository->find($id);

        if (!$disputa) {
            throw $this->createNotFoundException('No se encontró la disputa con ID: ' . $id);
        }

        return $this->render('disputas/index.html.twig', [
            'disputa' => $disputa,
            'equipo1' => $disputa->getEquipo1(),
            'equipo2' => $disputa->getEquipo2(),
            'eventos' => $eventoRepository->findBy(['torneo' => $disputa->getTorneo()]),
        ]);
    }
}