<?php

namespace App\Controller;

use App\Models\BirdsModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="bird_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function birdsList(): Response
    {
        // On instancie notre nouvelle classe
        $birdsModel = new BirdsModel();

        // On s'en sert pour récupérer la liste de tous les oiseaux
        $birds = $birdsModel->getBirds();
        // On envoie la liste des oiseaux à notre template
        return $this->render('main/index.html.twig', [
            'birds' => $birds,
        ]);
    }

    /**
     * @Route("bird/{id}", name="single", requirements={"id": "\d+"})
     */
    public function birdSingle(int $id): Response
    {
        // Il faut deux choses pour s'assurer d'avoir un entier dans $id
        //  - une option `reuiqrements` dans la dclaration de la route
        //  - du typehinting qui convertit l'information reçue en un entier
        // dd($id);
        
        $birdsModel = new BirdsModel();
        
        // On s'en sert pour récupérer la liste de tous les oiseaux
        $bird = $birdsModel->getSingleBird($id);
        // On envoie la liste des oiseaux à notre template
        if ($bird === null) {
            throw $this->createNotFoundException();
            // Après un throw, tout le reste n'est pas exécuté
        }

        // On ajoute le dernier oiseau vu dans la session, seulement s'il existe
        $session = new Session();
        $session->set('lastBird', $id);

        return $this->render('main/single.html.twig', [
            'bird' => $bird,
        ]);
    }

    /**
     * @Route("calendar", name="calendar")
     */
    public function calendar()
    {
        // $this->file() retourne un objet Response

        // On peut préciser à la méthode file() le nom d'un fichier
        // accessible à partir du dossier public
        // return $this->file('angry_birds_2015_calendar.pdf');

        // On peut préciser le chemin d'un fichier qui se trouve en dehors de norte projet Symfony
        // On peut donc aller chercher n'importe quel fichier pdf accessible à Symfony
        return $this->file(__DIR__ . '/../../../sources/angry_birds_2015_calendar.pdf');


        // Le premier argument de file() sert à préciser le fichier qu'on envoie au navigateur
        // Le deuxième permet de renommer le fichier
        // Avec le troisiême paramètre, il est possible de demander au navigateur de ne pas télécharger le fichier
        // return $this->file(__DIR__ . '/../../../sources/angry_birds_2015_calendar.pdf', 'calendar2021.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
