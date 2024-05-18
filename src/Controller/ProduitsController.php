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
    public function Index(ProduitsRepository $repo): Response
    {
        $produits = $repo->findAllSortedByName();
        $isProduitsUsed = [];

        foreach ($produits as $produit) {
            $isProduitsUsed[$produit->getId()] = $repo->isProduitsUsed($produit->getId());
        }

        return $this->render('produits/Gestion_Produits.html.twig', [
            'produits' => $produits,
            'message' => 'Gestion des Ingrédients',
            'isProduitsUsed' => $isProduitsUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Produit', name: 'Create_Produit')]
    public function Create(ProduitsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produits();
        $produits = $repo->findAllSortedByName();
        $isProduitsUsed = [];
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

        return $this->render('produits/Create_Produit.html.twig', [
            'produits' => $produits,
            'form' => $form,
            'message' => 'Gestion des Ingrédients',
            'isProduitsUsed' => $isProduitsUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************

    #[Route('/update_produit/{id}', name: 'update_produit')]
    public function Update(ProduitsRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $produits = $repo->findAllSortedByName();
        $isProduitsUsed = [];

        foreach ($produits as $produit) {
            $isProduitsUsed[$produit->getId()] = $repo->isProduitsUsed($produit->getId());
        }
        $produit = $repo->find($id);

        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute('Gestion_Produits');
        }

        return $this->render('produits/Update_Produit.html.twig', [
            'produits' => $produits,
            'form' => $form,
            'message' => 'Gestion des Ingrédients',
            'isProduitsUsed' => $isProduitsUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Produit_pop_Up/{id}', name: 'delete_Produit_pop_Up')]
    public function Delete_Pop_Up(Produits $prod, ProduitsRepository $repo): Response
    {
        $produits = $repo->findAllSortedByName();
        $isProduitsUsed = [];

        foreach ($produits as $produit) {
            $isProduitsUsed[$produit->getId()] = $repo->isProduitsUsed($produit->getId());
        }

        return $this->render('produits/Delete_Produit.html.twig', [
            'produit' => $prod,
            'produits' => $produits,
            'message' => 'Gestion des Ingrédients',
            'isProduitsUsed' => $isProduitsUsed,
        ]);
    }
    #[Route('/delete_Produit/{id}', name: 'delete_Produit')]
    public function Delete(Produits $prod, EntityManagerInterface $manager): Response
    {
        $manager->remove($prod);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Produits');
    }
}
