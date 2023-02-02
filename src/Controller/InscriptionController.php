<?php

namespace App\Controller;

use App\Entity\Sortie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionController extends AbstractController
{
    /**
     * Inscrit ou désinscrit un participant à un event
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Sortie $sortie, EventStateHelper $stateHelper): RedirectResponse
    {
        $em = $this->getManager();
        $inscriptionRepository = $em->getRepository('App:Inscription');

        //la sortie doit être à l'état "ouverte" pour s'inscrire
        if ($sortie -> getEtat()->getSortie() !== "open") {
            $this->addFlash('error', "Cette sortie n est pas ouverte aux inscriptions");
            return $this->redirectToRoute('sortie_liste', ["id" => $sortie->getId()]);
        }

        //si inscription trouvée, on la supprime en la cherchant dans la bdd
        $foundInscription = $inscriptionRepository->findOneBy(['user'=>$this->getUser(), 'sortie'=>$sortie]);
        if ($foundInscription) {
        //supprime l'inscription
        $em->remove($foundInscription);
        $em->flush();

        $this->addFlash('success', 'Vous êtes désinscrit');
        return $this->redirectToRoute('sortie_liste', ["id" => $sortie->getId()]);
        }

        //si la sortie est complète
        if ($sortie->isMaxedOut()) {
            $this->addFlash('error', "Cette sortie est complète");
            return $this->redirectToRoute('sortie_liste', ["id" => $sortie->getId()]);
        }

        //création et sauvegarde de l'inscription
        $inscription = new inscription();
        $inscription->setParticipant($this->getUser());
        $inscription- $this->setSortie($sortie);

        $em->persist($inscription);
        $em->flush();

        //rafraichit la sortie pour voir le nombre d'inscrits
        $em->refresh($inscription);

        //vérifie que tout est ok pour afficher l'état
        if ($sortie->isMaxedOut()) {
            $stateHelper->changeSortieState($sortie, 'closed');
        }
        $this->addFlash('success', 'Vous êtes inscrit');
        return $this->redirectToRoute('sortie_liste', ["id" => $sortie->getId()]);
    }



}