<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PageController extends AbstractController
{
    #[Route('/', name: 'inicio')]
    public function index(): Response
    {
        $user = $this->getUser();
         if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $torneos=$user->getTorneos();
        $seguidos=$user->getSeguidos();
        return $this->render('page/index.html.twig', [
            'torneos'=>$torneos,
            'seguidos'=>$seguidos,
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/torneo', name: 'torneo')]
    public function ligas(): Response
    {
        return $this->render('page/torneos.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/creaciontorneo', name: 'crear-torneo')]
    public function creacionligas(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('page/crear-torneo.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/fantasy', name: 'fantasy')]
    public function fantasy(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/creacionfantasy', name: 'creacionfantasy')]
    public function creacionfantasy(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    
}