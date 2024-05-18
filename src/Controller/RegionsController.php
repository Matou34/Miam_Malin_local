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
    public function Index(RegionsRepository $repo): Response
    {
        $regions = $repo->findAllSortedByName();
        $isRegionUsed = [];

        foreach ($regions as $region) {
            $isRegionUsed[$region->getId()] = $repo->isRegionUsed($region->getId());
        }

        return $this->render('regions/Gestion_Regions.html.twig', [
            'regions' => $regions,
            'message' => 'Gestion des régions',
            'isRegionUsed' => $isRegionUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Region', name: 'Create_Region')]
    public function Create(RegionsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $region = new Regions();
        $regions = $repo->findAllSortedByName();
        $isRegionUsed = [];
        $form = $this->createForm(RegionsType::class, $region);

        foreach ($regions as $region) {
            $isRegionUsed[$region->getId()] = $repo->isRegionUsed($region->getId());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $region = $form->getData();
            $manager->persist($region);
            $manager->flush();
            return $this->redirectToRoute('Gestion_Regions');
        }

        return $this->render('regions/Create_Region.html.twig', [
            'regions' => $regions,
            'form' => $form,
            'message' => 'Gestion des régions',
            'isRegionUsed' => $isRegionUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************

    #[Route('/update_regions/{id}', name: 'update_regions')]
    public function Update(RegionsRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $regions = $repo->findAllSortedByName();
        $isRegionUsed = [];

        foreach ($regions as $region) {
            $isRegionUsed[$region->getId()] = $repo->isRegionUsed($region->getId());
        }
        $region = $repo->find($id);

        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $region = $form->getData();
            $manager->persist($region);
            $manager->flush();

            return $this->redirectToRoute('Gestion_Regions');
        }

        return $this->render('regions/Update_Region.html.twig', [
            'regions' => $regions,
            'form' => $form,
            'message' => 'Gestion des régions',
            'isRegionUsed' => $isRegionUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Region_pop_Up/{id}', name: 'delete_Region_pop_Up')]
    public function Delete_Pop_Up(Regions $reg, RegionsRepository $repo): Response
    {
        $regions = $repo->findAllSortedByName();
        $isRegionUsed = [];

        foreach ($regions as $region) {
            $isRegionUsed[$region->getId()] = $repo->isRegionUsed($region->getId());
        }

        return $this->render('regions/Delete_Region.html.twig', [
            'region' => $reg,
            'regions' => $regions,
            'message' => 'Gestion des régions',
            'isRegionUsed' => $isRegionUsed,
        ]);
    }
    #[Route('/delete_region/{id}', name: 'delete_region')]
    public function Delete(Regions $reg, EntityManagerInterface $manager): Response
    {
        $manager->remove($reg);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Regions');
    }



}



