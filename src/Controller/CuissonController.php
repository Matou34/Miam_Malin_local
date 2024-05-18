<?php

namespace App\Controller;

use App\Entity\Cuisson;
use App\Form\CuissonType;
use App\Repository\CuissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CuissonController extends AbstractController
{
// *********************************************************************************************************************
//************** GESTION DES CUISSONS *******************//
// *********************************************************************************************************************
#[Route('/Gestion_Cuissons', name: 'Gestion_Cuissons')]
public function Index(CuissonRepository $repo, Request $request, EntityManagerInterface $manager, $id=null): Response
{
    $cuissons = $repo->findAllSortedByName();
    $isCuissonUsed = [];
    $cuisson = $id ? $repo->find($id) : new Cuisson();
    $form = $this->createForm(CuissonType::class, $cuisson);
    foreach ($cuissons as $existingCuisson) {
        $isCuissonUsed[$existingCuisson->getId()] = $repo->isCuissonUsed($existingCuisson->getId());
    }
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $cuisson = $form->getData();
        $manager->persist($cuisson);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Cuissons');
    }

    return $this->render('cuisson/Gestion_Cuissons.html.twig', [
        'cuissons' => $cuissons,
        'form' => $form->createView(),
        'cuisson' => $cuisson,
        'message' => 'Gestion des Mode de cuissons',
        'isCuissonUsed' => $isCuissonUsed,
    ]);
}
// *********************************************************************************************************************
//*************** CREATE *******************//
// *********************************************************************************************************************
#[Route('/Create_Cuisson', name: 'Create_Cuisson')]
public function Create(CuissonRepository $repo, Request $request, EntityManagerInterface $manager): Response
{
    $cuisson = new Cuisson();
    $form = $this->createForm(CuissonType::class, $cuisson);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $cuisson = $form->getData();
        $manager->persist($cuisson);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Cuissons');
    }
    if ($request->isXmlHttpRequest()) { // Vérifiez si la demande est une requête AJAX
        return new Response($this->renderView('cuisson/Create_Cuisson.html.twig', [
            'form' => $form->createView(),
        ]));
    } 
}
// *********************************************************************************************************************
//*************** UPDATE *******************//
// *********************************************************************************************************************
#[Route('/update_cuisson/{id}', name: 'update_cuisson')]
public function Update(CuissonRepository $repo, Request $request, EntityManagerInterface $manager, $id): Response
{
    $cuisson = $repo->find($id);
    $form = $this->createForm(CuissonType::class, $cuisson);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($cuisson);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Cuissons');
    }
    if ($request->isXmlHttpRequest()) { // Vérifiez si la demande est une requête AJAX
        return new Response($this->renderView('cuisson/Update_Cuisson.html.twig', [
            'form' => $form->createView(),
            'cuisson' => $cuisson,
        ]));
    } 
}
// *********************************************************************************************************************
//*************** DELETE *******************//
// *********************************************************************************************************************
    #[Route('/delete_cuisson/{id}', name: 'delete_cuisson')]
    public function Delete(Cuisson $cuis,Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('cuisson/Delete_Cuisson.html.twig', [
                'cuisson' => $cuis,
            ]));
        } 
        $manager->remove($cuis);
        $manager->flush();
        return $this->redirectToRoute('Gestion_Cuissons');
    }
}
