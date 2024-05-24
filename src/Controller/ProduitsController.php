<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    // *********************************************************************************************************************
    //************** GESTION DES PRODUITS *******************//
    // *********************************************************************************************************************
    #[Route('/Gestion_Produits', name: 'Gestion_Produits')]
    public function Index(ProduitsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $produits = $repo->findAllSortedByName();
        $isProduitsUsed = [];

        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);

        foreach ($produits as $produit) {
            $isProduitsUsed[$produit->getId()] = $repo->isProduitsUsed($produit->getId());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Produits');
        }

        return $this->render('produits/Gestion_Produits.html.twig', [
            'produits' => $produits,
            'message' => 'Gestion des Ingrédients',
            'isProduitsUsed' => $isProduitsUsed,
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }

    // *********************************************************************************************************************
    //************** AFFICHAGE DU TABLEAU *******************//
    // *********************************************************************************************************************
    #[Route('/Display_List_Produits', name: 'Display_List_Produits')]
    public function Display_List_Produits(ProduitsRepository $repo): Response
    {
        $produits = $repo->findAllSortedByName();
        $isProduitsUsed = [];

        foreach ($produits as $produit) {
            $isProduitsUsed[$produit->getId()] = $repo->isProduitsUsed($produit->getId());
        }
    
        return $this->render('produits/Display_List_Produits.html.twig', [
            'produits' => $produits,
            'isProduitsUsed' => $isProduitsUsed,
        ]);
    }


    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Produit', name: 'Create_Produit')]
    public function Create_Produit(ProduitsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produits();
        $produits = $repo->findAllSortedByName();
        $form = $this->createForm(ProduitsType::class, $produit);

        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('produits/Create_Produit.html.twig', [
                'form' => $form->createView(),
                'produits' => $produits,
            ]));
        } 
        }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************
    #[Route('/update_produit/{id}', name: 'update_produit')]
    public function Update_Produit(ProduitsRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $produit = $repo->find($id);
        $form = $this->createForm(ProduitsType::class, $produit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute('Gestion_Produits');
        }

        if ($request->isXmlHttpRequest()) { 
            return new Response($this->renderView('produits/Update_Produit.html.twig', [
                'form' => $form->createView(),
                'produit' => $produit,
            ]));
        } 
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Produit/{id}', name: 'delete_Produit')]
    public function Delete(Produits $prod,Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('produits/Delete_Produit.html.twig', [
                'produit' => $prod,
            ]));
        } 

        $manager->remove($prod);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Produits');
    }
}
