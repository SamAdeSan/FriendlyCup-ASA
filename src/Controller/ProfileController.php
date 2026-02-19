<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends AbstractController
{
    #[Route('/profile/{username}', name: 'user_profile')]
    public function index(string $username): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'torneos' => $user->getTorneos(), // Ajusta según tu relación
        ]);
    }

    #[Route('/profile/actualizar-avatar', name: 'user_update_avatar', methods: ['POST'])]
    public function updateAvatar(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $fotoFile = $request->files->get('avatar');

        if ($fotoFile) {
            $newFilename = uniqid().'.'.$fotoFile->guessExtension();

            try {
                // USAR EL PARÁMETRO DE SERVICES.YAML
                $fotoFile->move(
                    $this->getParameter('avatars_directory'),
                    $newFilename
                );

                // Borrar antigua si existe
                if ($user->getFoto()) {
                    $oldPath = $this->getParameter('avatars_directory').'/'.$user->getFoto();
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $user->setFoto($newFilename);
                $entityManager->flush();

                $this->addFlash('success', 'Imagen actualizada.');
            } catch (FileException $e) {
                // Manejar error
            }
        }

        return $this->redirectToRoute('user_profile', ['username' => $user->getUserIdentifier()]);
    }

    #[Route('/profile/borrar-avatar', name: 'user_delete_avatar', methods: ['POST'])]
    public function deleteAvatar(EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user && $user->getFoto()) {
            $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/avatars/' . $user->getFoto();

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $user->setFoto(null);
            $entityManager->flush();

            $this->addFlash('success', 'Foto eliminada.');
        }

        return $this->redirectToRoute('user_profile', ['username' => $user->getUserIdentifier()]);
    }
}