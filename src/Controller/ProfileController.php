<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends AbstractController
{
    /**
     * Actualizar el avatar del usuario logueado
     */
    #[Route('/profile/actualizar-avatar', name: 'user_update_avatar', methods: ['POST'])]
    public function updateAvatar(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $fotoFile = $request->files->get('avatar');

        if ($fotoFile) {
            $newFilename = uniqid().'.'.$fotoFile->guessExtension();

            try {
                $fotoFile->move($this->getParameter('avatars_directory'), $newFilename);

                // Borrar foto antigua si existe para ahorrar espacio
                if ($user->getFoto()) {
                    $oldPath = $this->getParameter('avatars_directory').'/'.$user->getFoto();
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $user->setFoto($newFilename);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', '¡Imagen actualizada!');
            } catch (FileException $e) {
                $this->addFlash('error', 'Error al subir la imagen.');
            }
        }

        return $this->redirectToRoute('user_profile', ['username' => $user->getName()]);
    }

    /**
     * Borrar el avatar actual
     */
    #[Route('/profile/borrar-avatar', name: 'user_delete_avatar', methods: ['POST'])]
    public function deleteAvatar(EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user && $user->getFoto()) {
            $filePath = $this->getParameter('avatars_directory') . '/' . $user->getFoto();
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $user->setFoto(null);
            $entityManager->flush();
            $this->addFlash('success', 'Foto eliminada.');
        }

        return $this->redirectToRoute('user_profile', ['username' => $user->getName()]);
    }

    /**
     * Ver perfil de cualquier usuario (esta ruta va al final para evitar conflictos)
     */
    #[Route('/profile/{username}', name: 'user_profile', requirements: ['username' => '^(?!actualizar-avatar|borrar-avatar).+'])]
    public function index(string $username, UserRepository $userRepo): Response
    {
        $userRequested = $userRepo->findOneBy(['name' => $username]);

        if (!$userRequested) {
            throw $this->createNotFoundException('El usuario no existe.');
        }

        return $this->render('profile/index.html.twig', [
            'user' => $userRequested,
            'torneos' => $userRequested->getTorneos(),
        ]);
    }
}