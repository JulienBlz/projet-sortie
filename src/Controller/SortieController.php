<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Controller;

use app\entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Ville;
use App\filtre\Recherche;
use App\Form\SortieType;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SortieController extends AbstractController
{
    /**
     * Création d'une sortie-
     *
     * @Route("/sortie/create", name="CreationSortie")
     */

    public function create(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {

        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        //gerrer les infos obligatoires ( organisateur, campus etc... )
        $organisateur = $this->getUser();
        $campus = $organisateur->getCampus();
        $sortie->setOrganisateur($organisateur);
        $sortie->setSiteOrganisateur($campus);

        //On prend les données du Formulaire de création des sorties:
        $sortieForm->handleRequest($request);

        //gerrer l'état:
        $etatCree = $etatRepository->findOneBy(array('libelle' => 'Créée'));
        $etatOuvert = $etatRepository->findOneBy(array('libelle' => 'Ouverte'));

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            if ($sortieForm->get('save')->isClicked()) {
                $sortie->setEtat($etatCree);
            } else if ($sortieForm->get('publish')->isClicked()) {
                $sortie->setEtat($etatOuvert);
            }

            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'Sortie créee!!');

            //todo: rediriger vers page détail des sorties.
            return $this->redirectToRoute('sortie_liste');
        }

        return $this->render('sortie/CreationSortie.html.twig', [
            "sortieForm" => $sortieForm->createView()
        ]);
    }

    /**
     * @Route("/sortie/liste", name="sortie_liste")
     */
    public function list(SortieRepository $sortieRepository, EtatRepository $etatRepository, EntityManagerInterface $entityManager, CampusRepository $campusRepository, Request $request): Response
    {
        //je recupere mon user connecté :
        $user = $this->getUser();
        $sorties = $sortieRepository->listeSortiesDefaut($user);

       //je recupere ma liste de sorties trier par defaut
       //$campuss = $campusRepository -> findAll();

        return $this->render('sortie/liste.html.twig', ["sorties" => $sorties,
           // "campuss" => $campuss,
        ]);
    }
}