<?php

namespace App\Controller;

use App\Entity\Tags;
use App\Form\TagsType;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    // *********************************************************************************************************************
    //************** GESTION DES TAGS *******************//
    // *********************************************************************************************************************
    #[Route('/Gestion_tags', name: 'Gestion_tags')]
    public function Index(TagsRepository $repo,Request $request, EntityManagerInterface $manager): Response
    {
        $tags = $repo->findAllSortedByName();
        $isTagUsed = [];

        $tag = new Tags();
        $form = $this->createForm(TagsType::class, $tag);


        foreach ($tags as $tag) {
            $isTagUsed[$tag->getId()] = $repo->isTagUsed($tag->getId());
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $manager->persist($tag);
            $manager->flush();
            return $this->redirectToRoute('Gestion_tags');
        }

        return $this->render('tags/Gestion_Tags.html.twig', [
            'tags' => $tags,
            'message' => 'Gestion des Tags',
            'isTagUsed' => $isTagUsed,
            'form' => $form->createView(),
            'tag' => $tag,
        ]);
    }

    // *********************************************************************************************************************
    //************** AFFICHAGE DU TABLEAU *******************//
    // *********************************************************************************************************************
    #[Route('/Display_List_Tags', name: 'Display_List_Tags')]
    public function Display_List_Tags(TagsRepository $repo): Response
    {
        $tags = $repo->findAllSortedByName();
        $isTagUsed = [];

        foreach ($tags as $tag) {
            $isTagUsed[$tag->getId()] = $repo->isTagUsed($tag->getId());
        }

        return $this->render('tags/Display_List_Tags.html.twig', [
            'tags' => $tags,
            'isTagUsed' => $isTagUsed,
        ]);
    }


    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Tag', name: 'Create_Tag')]
    public function Create_Tag(TagsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $tag = new Tags();
        $tags = $repo->findAllSortedByName();
        $form = $this->createForm(TagsType::class, $tag);

        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('tags/Create_Tag.html.twig', [
                'form' => $form->createView(),
                'tags' => $tags,
            ]));
        } 
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************
    #[Route('/update_tags/{id}', name: 'update_tags')]
    public function Update_Tag(TagsRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {

        $tag = $repo->find($id);
        $form = $this->createForm(TagsType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tag);
            $manager->flush();

            return $this->redirectToRoute('Gestion_tags');
        }

        if ($request->isXmlHttpRequest()) { 
            return new Response($this->renderView('tags/Update_Tag.html.twig', [
                'form' => $form->createView(),
                'tag' => $tag,
            ]));
        } 
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Tag/{id}', name: 'delete_Tag')]
    public function Delete_Tag(Tags $tag,Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return new Response($this->renderView('tags/Delete_Tag.html.twig', [
                'tag' => $tag,
            ]));
        } 

        $manager->remove($tag);
        $manager->flush();
        return $this->redirectToRoute('Gestion_tags');
    }

}    




