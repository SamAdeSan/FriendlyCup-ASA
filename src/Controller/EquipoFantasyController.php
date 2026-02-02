<?php

namespace App\Controller;

use App\Entity\EquipoFantasy;
use App\Repository\EquipoFantasyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/equipo-fantasy')]
class EquipoFantasyController extends AbstractController
{
     #[Route('/{id}', name: 'equipo_fantasy_show')]
    public function show(int $id,EquipoFantasyRepository $equipoFantasyRepository): Response
    {
        $equipoFantasy=$equipoFantasyRepository->find($id);
        $liga=$equipoFantasy->getLigafantasy();
        $jugadores=$equipoFantasy->getTitulares();
        $entrenador=$equipoFantasy->getEntrenador();
        return $this->render('equipo_fantasy/show.html.twig', [
            'equipoFantasy' => $equipoFantasy,
            'liga' => $liga,
            'jugadores' => $jugadores,
            'entrenador' => $entrenador
        ]);
    }
   
}