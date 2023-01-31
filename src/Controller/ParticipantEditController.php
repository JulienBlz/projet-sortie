<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ParticipantEditController extends AbstractController
{

    /**
     * @Route("/mon_profil", name="app_participant_edit")
     */
    //ici on fais apelle au request pour la requette a la bdd,entitymanager pour recuper les info user et les userpassword pour hasher le mot de passe
    public function modify(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        //ici on recupere le user pour crée le formulaire avec ses info
        $Participant = $this->getUser();
        $form = $this->createForm(ParticipantType::class,$Participant);
        $form->handleRequest($request);
        //ici si le formulaire a été modifié et qu'il est valide dans le form on le traite et confirme l'envois a l'user
        if($form->isSubmitted() && $form->isValid())
        {
            $Participant->setMotPasse(
                $userPasswordHasher->hashPassword(
                    $Participant,
                    $form->get('motPasse')->getData()
                )
            );
            $entityManager->persist($Participant);
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a bien été modifié');
        }
        return $this->render('participant_edit/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
