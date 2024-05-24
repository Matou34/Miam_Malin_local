<?php

namespace App\Controller;

use App\Repository\EtapesRepository;
use App\Repository\QuantitesRepository;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(RecettesRepository $repoRecette, EtapesRepository $repoEtapes, QuantitesRepository $repoQuantites, EntityManagerInterface $manager): Response
    {
        $recettes= $repoRecette->findAll();
        $etapes = $repoEtapes->findAll();
        $quantites = $repoQuantites->findAll();

        return $this->render('accueil/accueil.html.twig', [
            'recettes' => $recettes,
            'etapes' => $etapes,
            'quantites' => $quantites,
        ]);
    }

    // #[Route('/recettedetail/{id}', name: 'recette_details')]
    // public function product_detail(RecettesRepository $repoRecette, EtapesRepository $repoEtapes, QuantitesRepository $repoQuantites, EntityManagerInterface $manager, $id = null):Response
    // {
    // $recette_details = $repoRecette->find($id);
    // $recette = $repoRecette->findAll();
    // $etape = $repoEtapes->findAll();
    // $quantite = $repoQuantites->findAll();
    // return $this->render('accueil/recette.html.twig',[
    //     'recette_detail' => $recette_details,
    //     'etape' => $etape,
    //     'quantite' => $quantite,
    //     'recette' => $recette
    // ]);
    
    // }


}
