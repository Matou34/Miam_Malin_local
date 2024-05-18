<?php

namespace App\Controller;

use App\Entity\Etapes;
use App\Entity\Recettes;
use App\Form\EtapesType;
use App\Repository\EtapesRepository;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtapesController extends AbstractController
{
    #[Route('/Create_etapes/{id}', name: 'Create_etapes')]
    public function Create(EtapesRepository $repo,RecettesRepository $repoRecettes, Request $request, EntityManagerInterface $manager, $id): Response
    {
        $recettes = $repoRecettes->findAllSortedByName(); 

        $etape = new Etapes();
        $etapes = $repo->findAll();
        $form = $this->createForm(EtapesType::class, $etape);
        $form->handleRequest($request);
        $recette = $manager->getRepository(Recettes::class)->find($id);
        $recetteId = $request->get('id');
        


    if ($form->isSubmitted() && $form->isValid()) {
        $etape = $form->getData();        
        $etape->setRecette($recette);
        $manager->persist($etape);
        $manager->flush();
        return $this->redirectToRoute('Create_Qantites', [
            'etapeId' => $etape->getId(),
            'recetteId' => $recetteId,
        ]);
    }
    return $this->render('etapes/Create_Etape.html.twig', [
        'recettes' => $recettes,
        'etapes' => $etapes,
        'form' => $form,
        'message' => 'Ajouter une Etape',
        'recette' => $recette, 
        ]);
    }

    #[Route('etapes/update/{etapeId}/{recetteId}', name: 'etapes_update')]
    public function update(Etapes $etape,EtapesRepository $etapesRepository, RecettesRepository $repoRecettes,Recettes $recettes, Request $request,EntityManagerInterface $manager,$etapeId,$recetteId): Response 
    {
                //--------- RECETTE DETAIL --------
                $ingredientsAggreges = [];

                foreach ($recettes->getEtapes() as $etape) {
                    foreach ($etape->getQuantites() as $quantite) {
                        $produit = $quantite->getProduits();
                        $unite = $quantite->getUnites();
                        $nomIngredient = $produit ? $produit->getPRLIBELLE() : '';
                        if (!$produit && !$nomIngredient) {
                            continue;
                        }
        
                        if (!array_key_exists($nomIngredient, $ingredientsAggreges)) {
                            $ingredientsAggreges[$nomIngredient] = [
                                'quantite' => 0,
                                'unite' => $unite ? $unite->getUnLibelle() : ''
                            ];
                        }
                        $ingredientsAggreges[$nomIngredient]['quantite'] += $quantite->getQuQuantites() ?? '';
                    }
                }
                $etapes = $etapesRepository->findAll();
                $form = $this->createForm(EtapesType::class, $etape);
        $form->handleRequest($request);
    
        // Ici, nous utilisons directement $recetteId passé à la méthode.
        $recette = $manager->getRepository(Recettes::class)->find($recetteId);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($etape);
            $manager->flush();
    
            return $this->redirectToRoute('Update_Quantites', [
                'etapeId' => $etape->getId(),
                'recetteId' => $recetteId,
            ]);
        }
    
        return $this->render('etapes/Etape_Update.html.twig', [
            'recette' => $recette, // Assurez-vous que c'est le nom correct de la variable attendue dans le template.
            'etape' => $etape, // Ici, 'etapes' a été changé en 'etape' pour correspondre à la variable que vous avez déclarée.
            'etapes' => $etapes, // Ici, 'etapes' a été changé en 'etape' pour correspondre à la variable que vous avez déclarée.
            'form' => $form, // Assurez-vous de passer createView() pour le formulaire.
            'message' => 'Modifier une étape',
            'ingredientsAggreges' => $ingredientsAggreges,
        ]);
    }
    // public function update(Etapes $etape,RecettesRepository $repoRecettes, Request $request, EntityManagerInterface $manager, $etapeId, $recetteId): Response
    // {        
    //         $form = $this->createForm(EtapesType::class, $etape);
    //         $form->handleRequest($request);
    //         $recette = $manager->getRepository(Recettes::class)->find($recetteId);
    //         $recetteId = $request->get('id');
    
    //         if($form->isSubmitted() && $form->isValid()) {
    //             $etape = $form->getData();
    //             $recette = $manager->getRepository(Recettes::class)->find($recetteId);
    //             $etape->setRecette($recette);
    //             $manager->persist($etape);
    //             $manager->flush();
    //             return $this->redirectToRoute('Update_Qantites', [
    //                 'etapeId' => $etape->getId(),
    //                 'recetteId' => $recetteId,
    //             ]);
    //                 }

    //         return $this->render('etapes/Etape_Update.html.twig', [
    //             'recettes' => $recette,
    //             'etapes' => $etape,
    //             'form' => $form,
    //             'message' => 'Modifier une étape',
    //             'etapeId' => $etape->getId(),
    //             'recetteId' => $recetteId,
                
    //         ]);
    //     }


}
