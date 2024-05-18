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
    public function Index(UnitesRepository $repo): Response
    {
        $unites = $repo->findAllSortedByName();
        $isInitesUsed = [];

        foreach ($unites as $Unite) {
            $isInitesUsed[$Unite->getId()] = $repo->isInitesUsed($Unite->getId());
        }

        return $this->render('unites/Gestion_Unites.html.twig', [
            'unites' => $unites,
            'message' => 'Gestion des Unités',
            'isInitesUsed' => $isInitesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Unite', name: 'Create_Unite')]
    public function Create(UnitesRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $unite = new Unites();
        $unites = $repo->findAllSortedByName();
        $isInitesUsed = [];
        $form = $this->createForm(UnitesType::class, $unite);

        foreach ($unites as $unite) {
            $isInitesUsed[$unite->getId()] = $repo->isInitesUsed($unite->getId());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unite = $form->getData();
            $manager->persist($unite);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Unites');
        }

        return $this->render('unites/Create_Unites.html.twig', [
            'unites' => $unites,
            'form' => $form,
            'message' => 'Gestion des Unités',
            'isInitesUsed' => $isInitesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************

    #[Route('/Update_Unite/{id}', name: 'Update_Unite')]
    public function Update(UnitesRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $unites = $repo->findAllSortedByName();
        $isInitesUsed = [];

        foreach ($unites as $unite) {
            $isInitesUsed[$unite->getId()] = $repo->isInitesUsed($unite->getId());
        }
        $unite = $repo->find($id);

        $form = $this->createForm(UnitesType::class, $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unite = $form->getData();
            $manager->persist($unite);
            $manager->flush();

            return $this->redirectToRoute('Gestion_Unites');
        }

        return $this->render('unites/Update_Unites.html.twig', [
            'unites' => $unites,
            'form' => $form,
            'message' => 'Gestion des Unités',
            'isInitesUsed' => $isInitesUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Unite_pop_Up/{id}', name: 'delete_Unite_pop_Up')]
    public function Delete_Pop_Up(Unites $Unit, UnitesRepository $repo): Response
    {
        $unites = $repo->findAllSortedByName();
        $isInitesUsed = [];

        foreach ($unites as $unite) {
            $isInitesUsed[$unite->getId()] = $repo->isInitesUsed($unite->getId());
        }

        return $this->render('unites/Delete_Unite.html.twig', [
            'unite' => $Unit,
            'unites' => $unites,
            'message' => 'Gestion des Unités',
            'isInitesUsed' => $isInitesUsed,
        ]);
    }
    #[Route('/delete_Unite/{id}', name: 'delete_Unite')]
    public function Delete(Unites $unite, EntityManagerInterface $manager): Response
    {
        $manager->remove($unite);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Unites');
    }

}

