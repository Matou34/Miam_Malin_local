<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Form\RegionsType;
use App\Repository\RegionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegionsController extends AbstractController
{
    // *********************************************************************************************************************
    //************** GESTION DES REGIONS *******************//
    // *********************************************************************************************************************
    #[Route('/Gestion_Regions', name: 'Gestion_Regions')]
    public function Index(RegionsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $regions = $repo->findAllSortedByName();
        $isRegionUsed = [];

        foreach ($regions as $region) {
            $isRegionUsed[$region->getId()] = $repo->isRegionUsed($region->getId());
        }
        $region = new Regions();
        $form = $this->createForm(RegionsType::class, $region);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $region = $form->getData();
            $manager->persist($region);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Regions');
        }

        return $this->render('regions/Gestion_regions.html.twig', [
            'regions' => $regions,
            'message' => 'Gestion des régions',
            'isRegionUsed' => $isRegionUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** AFFICHAGE DU TABLEAU *******************//
    // *********************************************************************************************************************
    #[Route('/Display_List_Regions', name: 'Display_List_Regions')]
    public function Display_List_Regions(RegionsRepository $repo): Response
    {
        $regions = $repo->findAllSortedByName();
        $isRegionUsed = [];

        foreach ($regions as $region) {
            $isRegionUsed[$region->getId()] = $repo->isRegionUsed($region->getId());
        }

        return $this->render('regions/Dipslay_List_Regions.html.twig', [
            'regions' => $regions,
            'isRegionUsed' => $isRegionUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************
    #[Route('/Create_Region', name: 'Create_Region')]
    public function Create_Region(RegionsRepository $repo, Request $request): Response
    {
        $region = new Regions();
        $regions = $repo->findAllSortedByName();
        $form = $this->createForm(RegionsType::class, $region);

        if ($request->isXmlHttpRequest()) { 
            return new Response($this->renderView('regions/Create_Region.html.twig', [
                'form' => $form->createView(),
                'regions' => $regions,    
            ]));
        } 
        return $this->render('regions/Create_Region.html.twig', [
            'form' => $form->createView(),
            'regions' => $regions,
        ]);
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************
    #[Route('/update_regions/{id}', name: 'update_regions')]
    public function Update_Region(RegionsRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $region = $repo->find($id);
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $region = $form->getData();
            $manager->persist($region);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Regions');
        }
        if ($request->isXmlHttpRequest()) { // Vérifiez si la demande est une requête AJAX
            return new Response($this->renderView('regions/Update_Region.html.twig', [
                'form' => $form->createView(),
                'region' => $region,
            ]));
        } 

        return $this->render('regions/Update_Region.html.twig', [
            'regions' => $region,
            'form' => $form,
        ]);
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_region/{id}', name: 'delete_region')]
    public function Delete_Region(Regions $reg,Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('regions/Delete_Region.html.twig', [
                'region' => $reg,
            ]));
        } 

        $manager->remove($reg);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Regions');
    }



}



