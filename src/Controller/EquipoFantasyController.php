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
    #[Route('/{id}/fichar', name:'equipo_fantasy_fichar', methods: ['POST'])]
    public function fichar(){
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
    }




    #[Route('/{id}', name: 'equipo_fantasy_show')]
    public function show(int $id, EquipoFantasyRepository $equipoFantasyRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $equipoFantasy = $equipoFantasyRepository->find($id);
        $liga = $equipoFantasy->getLigafantasy();
        $jugadores = $equipoFantasy->getTitulares();
        $entrenador = $equipoFantasy->getEntrenador();
        $equipoFantasy2 = $equipoFantasyRepository->findOneBy(['entrenador' => $user, 'ligafantasy' => $liga]);
        return $this->render('fantasy/equipofantasy.html.twig', [
            'equipoFantasy' => $equipoFantasy,
            'liga' => $liga,
            'jugadores' => $jugadores,
            'entrenador' => $entrenador,
            'equipoFantasy2' => $equipoFantasy2
        ]);
    }

}