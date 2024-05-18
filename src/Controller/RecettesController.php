<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\RecettesType;
use App\Repository\RecettesRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\IngredientsAggreges;

class RecettesController extends AbstractController
{
    // *********************************************************************************************************************
    //************** GESTION RECETTES *******************//
    // *********************************************************************************************************************

    #[Route('/recette_list', name: 'recette_list')]
    public function recette_list(RecettesRepository $repo): Response
    {
        $recettes = $repo->findAllSortedByName();

        return $this->render('recettes/gestionRecettte.html.twig', [
            'recettes' => $recettes,
            'message' => 'Ajouter une recette'
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE *******************//
    // *********************************************************************************************************************
    #[Route('/Create_recette', name: 'Create_recette')]
    public function Create(RecettesRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $recette = new Recettes();
        $recettes = $repo->findAllSortedByName();
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $recette = $form->getData();
            $manager->persist($recette);

            $manager->flush();
            return $this->redirectToRoute('Create_etapes', ['id' => $recette->getId()]);
        }
        return $this->render('recettes/Create_Recette.html.twig', [
            'recettes' => $recettes,
            'form' => $form,
            'message' => 'Ajouter une recette',
        ]);
    }

    // *********************************************************************************************************************
    //************** UPDATE *******************//
    // *********************************************************************************************************************
    // *********************************************************************************************************************

    #[Route('recettes/update/{id}', name: 'recette_update')]
    public function Update(Recettes $Recet, IngredientsAggreges $ingredientsAggreges): Response
    {
        //--------- RECETTE DETAIL --------
        $ingredientsAggreges->Ingrédients($Recet);
        // $ingredientsAggreges = [];

        // foreach ($Recet->getEtapes() as $etape) {
        //     foreach ($etape->getQuantites() as $quantite) {
        //         $produit = $quantite->getProduits();
        //         $unite = $quantite->getUnites();
        //         $nomIngredient = $produit ? $produit->getPRLIBELLE() : '';

        //         if (!$produit && !$nomIngredient) {
        //             continue;
        //         }

        //         if (!array_key_exists($nomIngredient, $ingredientsAggreges)) {
        //             $ingredientsAggreges[$nomIngredient] = [
        //                 'quantite' => 0,
        //                 'unite' => $unite ? $unite->getUnLibelle() : ''
        //             ];
        //         }
        //         $ingredientsAggreges[$nomIngredient]['quantite'] += $quantite->getQuQuantites() ?? '';
        //     }
        // }
        return $this->render('recettes/update_recette.html.twig', [
            'recette' => $Recet,
            'ingredientsAggreges' => $ingredientsAggreges,
            'message' => 'Modifier une recette'

        ]);
    }
    #[Route('recettes/update_Final/{id}', name: 'recette_update_Final')]
    public function UpdateFinal(Recettes $recette, Request $request, RecettesRepository $repo, EntityManagerInterface $manager, FileUploader $fileUploader, IngredientsAggreges $ingredientsAggreges): Response
    {
        //--------- RECETTE DETAIL --------
        $ingredientsAggreges->Ingrédients($recette);

        // $ingredientsAggreges = [];

        // foreach ($recette->getEtapes() as $etape) {
        //     foreach ($etape->getQuantites() as $quantite) {
        //         $produit = $quantite->getProduits();
        //         $unite = $quantite->getUnites();
        //         $nomIngredient = $produit ? $produit->getPRLIBELLE() : '';

        //         if (!$produit && !$nomIngredient) {
        //             continue;
        //         }

        //         if (!array_key_exists($nomIngredient, $ingredientsAggreges)) {
        //             $ingredientsAggreges[$nomIngredient] = [
        //                 'quantite' => 0,
        //                 'unite' => $unite ? $unite->getUnLibelle() : ''
        //             ];
        //         }
        //         $ingredientsAggreges[$nomIngredient]['quantite'] += $quantite->getQuQuantites() ?? '';
        //     }
        // }
        
        // -------- UPDATE -----------  
        $recettes = $repo->findAll();

        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        $oldFile = $recette->getReImage();
        if ($form->isSubmitted()) {
            
            $imageFile = $form->get('imageFile')->getData();
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            if ($originalFilename != $oldFile) {
                
                $fileUploader->removeFile($oldFile);
            }

            $recette = $form->getData();
            $recette->setReImage($originalFilename);
            $manager->persist($recette);
            $manager->flush();

            return $this->redirectToRoute('recette_update', ['id' => $recette->getId()]);
        }

        return $this->render('recettes/Update_recette_Pop_up.html.twig', [
            'recettes' => $recettes,
            'recette' => $recette,
            'form' => $form,
            'ingredientsAggreges' => $ingredientsAggreges,
            'message' => 'Gestion des recettes',
        ]);
    }

    // *********************************************************************************************************************
    //************** RECETTE DETAIL *******************//
    // *********************************************************************************************************************

    #[Route('/Detail_Recette/{id}', name: 'Detail_Recette')]
    public function recette_detail(Recettes $recet, IngredientsAggreges $ingredientsAggreges ): Response
    {
        $ingredientsAggreges->Ingrédients($recet);
        // $ingredientsAggreges = [];

        // foreach ($recet->getEtapes() as $etape) {
        //     foreach ($etape->getQuantites() as $quantite) {
        //         $produit = $quantite->getProduits();
        //         $unite = $quantite->getUnites();
        //         $nomIngredient = $produit ? $produit->getPRLIBELLE() : '';

        //         if (!$produit && !$nomIngredient) {
        //             continue;
        //         }

        //         if (!array_key_exists($nomIngredient, $ingredientsAggreges)) {
        //             $ingredientsAggreges[$nomIngredient] = [
        //                 'quantite' => 0,
        //                 'unite' => $unite ? $unite->getUnLibelle() : ''
        //             ];
        //         }
        //         $ingredientsAggreges[$nomIngredient]['quantite'] += $quantite->getQuQuantites() ?? 0;
        //     }
        // }

        return $this->render('recettes/Detail_Recette.html.twig', [
            'recette' => $recet,
            'ingredientsAggreges' => $ingredientsAggreges,
        ]);
    }

    // *********************************************************************************************************************
    //************** RECHERCHE RECETTE *******************//
    // *********************************************************************************************************************
    #[Route('/recherche', name: 'recherche_recette')]
    public function recherche(Request $request, RecettesRepository $recetteRepository)
    {
        $term = $request->query->get('q', '');
        $recettes = [];

        if (!empty($term)) {
            $recettes = $recetteRepository->findByTerm($term);
        }

        return $this->render('recettes/gestionRecettte.html.twig', [
            'recettes' => $recettes,
            'message' => "recette trouvée"
        ]);
    }

    // *********************************************************************************************************************

    #[Route('/recette/delete/{id}', name: 'recette_delete')]
    public function delete(Recettes $recette, EntityManagerInterface $entityManager, $id): Response
    {
        if (!$recette) {
            throw $this->createNotFoundException('Aucune recette trouvée pour l\'id ' . $id);
        }
        // $nameFile = $recette->getReImage()
        // unlike('/public/recettes/'.$nameFile)
        $entityManager->remove($recette);
        $entityManager->flush();

        $this->addFlash('success', 'La recette a été supprimée avec succès.');

        return $this->redirectToRoute('recette_list');
    }
    // *********************************************************************************************************************

    // #[Route('/recettes/{id}', name: 'app_recette_details')]
    // public function details(int $id, RecettesRepository $repo ): Response
    // {   
    //     $recette = $repo->find($id);
    //     if (!$recette) {
    //         throw $this->createNotFoundException('Recette non trouvée');
    //     }

    //     return $this->render('recettes/details.html.twig', [
    //         'recette' => $recette,
    //     ]);
    // }

}
