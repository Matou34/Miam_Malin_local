<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CategoriesController extends AbstractController
{
    // *********************************************************************************************************************
    //************** GESTION DES CATEGORIES *******************//
    // *********************************************************************************************************************
    #[Route('/Gestion_Catégorie', name: 'Gestion_Catégorie')]
    public function Index(CategoriesRepository $repo): Response
    {
        $categories = $repo->findAllSortedByName();
        $categoriesUsed = [];

        foreach ($categories as $categorie) {
            $categoriesUsed[$categorie->getId()] = $repo->isCategorieUsed($categorie->getId());
        }

        return $this->render('categories/Gestion_Categories.html.twig', [
            'categories' => $categories,
            'message' => 'Gestion des Catégories',
            'categoriesUsed' => $categoriesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Catégorie', name: 'Create_Catégorie')]
    public function Create(CategoriesRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $categorie = new Categories();
        $categories = $repo->findAllSortedByName();
        $categoriesUsed = [];
        $form = $this->createForm(CategoriesType::class, $categorie);

        foreach ($categories as $categorie) {
            $categoriesUsed[$categorie->getId()] = $repo->isCategorieUsed($categorie->getId());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Catégorie');
        }

        return $this->render('categories/Create_Categorie.html.twig', [
            'categories' => $categories,
            'form' => $form,
            'message' => 'Gestion des Catégories',
            'categoriesUsed' => $categoriesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************

    #[Route('/Update/{id}', name: 'Update_categories')]
    public function Update(CategoriesRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $categories = $repo->findAllSortedByName();
        $categoriesUsed = [];

        foreach ($categories as $categorie) {
            $categoriesUsed[$categorie->getId()] = $repo->isCategorieUsed($categorie->getId());
        }
        $categorie = $repo->find($id);

        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();

            return $this->redirectToRoute('Gestion_Catégorie');
        }

        return $this->render('categories/Update_Categories.html.twig', [
            'categories' => $categories,
            'form' => $form,
            'message' => 'Gestion des Catégories',
            'categoriesUsed' => $categoriesUsed,
        ]);
    }



    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_categories_pop_Up/{id}', name: 'delete_categories_pop_Up')]
    public function Delete_Pop_Up(Categories $categ, CategoriesRepository $repo, EntityManagerInterface $manager): Response
    {
        $categories = $repo->findAllSortedByName();
        //$categorie = $repo->find($id);
        //$libelleCategorie = $categ->getCaLibelle();
        $categoriesUsed = [];

        foreach ($categories as $categorie) {
            $categoriesUsed[$categorie->getId()] = $repo->isCategorieUsed($categorie->getId());
        }

        return $this->render('categories/Delete_Categorie.html.twig', [
            'categorie' => $categ,
            'categories' => $categories,
            'message' => 'Gestion des Catégories',
            'categoriesUsed' => $categoriesUsed,
        ]);
    }
    #[Route('/delete_categories/{id}', name: 'delete_categories')]
    public function Delete(Categories $categorie, EntityManagerInterface $manager): Response
    {
        $manager->remove($categorie);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Catégorie');
    }
}
