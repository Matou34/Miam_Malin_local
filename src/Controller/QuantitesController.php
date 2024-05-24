<?php

namespace App\Controller;

use App\Entity\Etapes;
use App\Entity\Quantites;
use App\Form\QuantitesType;
use App\Repository\EtapesRepository;
use App\Repository\QuantitesRepository;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuantitesController extends AbstractController
{
    // *********************************************************************************************************************
    //************** CREATE *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Qantites/{etapeId}/{recetteId}', name: 'Create_Qantites')]
    public function Create(QuantitesRepository $repo,RecettesRepository $repoRecettes,EtapesRepository $repoEtape, Request $request, EntityManagerInterface $manager,$recetteId,$etapeId)  : Response
    {
        $recettes = $repoRecettes->findAllSortedByName(); 

        $quantite = new Quantites();
        $quantites = $repo->findAll();
        $form = $this->createForm(QuantitesType::class, $quantite);
        $form->handleRequest($request);
        $etape = $repoEtape->find($etapeId);
        $recette = $repoRecettes->find($recetteId);    
        $etape = $repoEtape->find($etapeId);
        $recette = $repoRecettes->find($recetteId);

        $etapeId = $etape->getId();
        $recetteId = $recette->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $quantite = $form->getData();
            $etpape = $manager->getRepository(Etapes::class)->find($etapeId);
            $quantite->setEtapes($etpape);
            $manager->persist($quantite);
            $manager->flush();
            // return $this->redirectToRoute('recette_list');
            $action = $request->request->get('action');

            if ($action == 'add_and_continue') {
                // Redirige vers le formulaire pour ajouter une nouvelle quantité
                return $this->redirectToRoute('Create_Qantites', [
                    'etapeId' => $etapeId,
                    'recetteId' => $recetteId
                ]);
            } else if ($action == 'add_and_finish') {
                // Redirige vers la gestion des recettes
                return $this->redirectToRoute('recette_list');
            }
            else if ($action == 'add_and_New_etape') {
                // Redirige vers la gestion des recettes
                return $this->redirectToRoute('Create_etapes', [
                    'id' => $recetteId,
                ]);
            }
    
        }
    
        return $this->render('quantites/Create_Qantites.html.twig', [
            'quantites' => $quantites,
            'recettes' => $recettes,
            'recetteId' => $recetteId,
            'form' => $form,
            'etapeId' => $etapeId, 
            'message' => 'Ajouter une quantitée',
            'etape' => $etape,
            'recette' => $recette,

            ]);
    }

    #[Route('quantites/update/{id}', name: 'quantites_update')]
    public function update(Request $request, QuantitesRepository $repo, EntityManagerInterface $manager, $id=null): Response
    {
        
            $quantite = $repo->find($id);
            $quantites = $repo->findAll();
            $form = $this->createForm(QuantitesType::class, $quantite);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $quantite = $form->getData();
                $manager->persist($quantite);
                $manager->flush();
                $this->addFlash('success', 'Votre quantité à était modifiée.');
                return $this->redirectToRoute('app_accueil', ['id' => $quantite->getId()]);
            }

            return $this->render('quantites/index.html.twig', [
                'products' => $quantites,
                'form' => $form,
                'message' => 'Modifier la quantitée'
            ]);
        }


}
