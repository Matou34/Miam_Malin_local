<?php

namespace App\Controller;

use App\Entity\Unites;
use App\Form\UnitesType;
use App\Repository\UnitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnitesController extends AbstractController
{
    // *********************************************************************************************************************
    //************** GESTION DES UNITES *******************//
    // *********************************************************************************************************************
    #[Route('/Gestion_Unites', name: 'Gestion_Unites')]
    public function Index(UnitesRepository $repo,Request $request, EntityManagerInterface $manager): Response
    {
        $unites = $repo->findAllSortedByName();
        $isInitesUsed = [];

        $unite = new Unites();
        $form = $this->createForm(UnitesType::class, $unite);

        foreach ($unites as $Unite) {
            $isInitesUsed[$Unite->getId()] = $repo->isInitesUsed($Unite->getId());
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unite = $form->getData();
            $manager->persist($unite);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Unites');
        }
    

        return $this->render('unites/Gestion_Unites.html.twig', [
            'unites' => $unites,
            'form' => $form->createView(),
            'unite' => $unite,
            'message' => 'Gestion des Unités',
            'isInitesUsed' => $isInitesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** AFFICHAGE DU TABLEAU *******************//
    // *********************************************************************************************************************
    #[Route('/Display_List_Unites', name: 'Display_List_Unites')]
    public function Display_List_Unites(UnitesRepository $repo): Response
    {
        $unites = $repo->findAllSortedByName();
        $isInitesUsed = [];

        foreach ($unites as $Unite) {
            $isInitesUsed[$Unite->getId()] = $repo->isInitesUsed($Unite->getId());
        }

        return $this->render('unites/Display_List_Unite.html.twig', [
            'unites' => $unites,
            'isInitesUsed' => $isInitesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Unite', name: 'Create_Unite')]
    public function Create_Unite(UnitesRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $unite = new Unites();
        $unites = $repo->findAllSortedByName();
        $form = $this->createForm(UnitesType::class, $unite);

        if ($request->isXmlHttpRequest()) { 
            return new Response($this->renderView('unites/Create_Unites.html.twig', [
                'form' => $form->createView(),
                'unites' => $unites,    
            ]));
        } 
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************

    #[Route('/Update_Unite/{id}', name: 'Update_Unite')]
    public function Update_Unite(UnitesRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $unite = $repo->find($id);
        $form = $this->createForm(UnitesType::class, $unite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($unite);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Unites');
        }
        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('unites/Update_Unites.html.twig', [
                'form' => $form->createView(),
                'unite' => $unite,
            ]));
        } 
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Unite/{id}', name: 'delete_Unite')]
    public function Delete_Unite(Unites $unite,Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('unites/Delete_Unite.html.twig', [
                'unite' => $unite,
            ]));
        } 

        $manager->remove($unite);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Unites');
    }

}

