<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AffichageprecisController extends AbstractController


{



    /**
     * @Route("/sortie/detail/{id}", name="app_sortie_detaille")
     */
    public function show($id,EntityManagerInterface $entityManager)
    {
        $sortie = $entityManager->getRepository(Sortie::class)
            ->find($id);

        if (!$sortie) {
            throw $this->createNotFoundException(
                'No sortie found for id '.$id
            );
        }

        return $this->render('affichageprecis/index.html.twig', [
            'sortie' => $sortie,
        ]);
    }
}