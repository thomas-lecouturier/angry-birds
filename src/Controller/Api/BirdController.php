<?php

namespace App\Controller\Api;

use App\Models\BirdsModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/bird", name="api_bird_")
 */
class BirdController extends AbstractController
{
    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(BirdsModel $birdsModel): Response
    {
        // On souhaite afficher tous les oiseaux en JSON
        // Il faut d'abord récupérer tous les oiseaux
        // $birdsModel = new BirdsModel();

        $birds = $birdsModel->getBirds();

        return $this->json($birds);
    }

    /**
     * Il est tout à fait possible de recréer la même route en précisant qu'elle n'accpte que le POST
     * Bien sûr, il lui faut un autre nom de route et de méthode !
     * 
     * Normalement une route API en POSt permet d'ajouter une information en BDD
     * Ici on ne joue pas encore avec la BDD donc la route en POST fait la même chose que la route en GET
     * 
     * @Route("", name="add", methods={"POST"})
     */
    public function add(): Response
    {
        // On souhaite afficher tous les oiseaux en JSON
        // Il faut d'abord récupérer tous les oiseaux
        $birdsModel = new BirdsModel();

        $birds = $birdsModel->getBirds();

        return $this->json($birds);
    }
}
