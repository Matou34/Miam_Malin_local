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
    public function Index(TagsRepository $repo): Response
    {
        $tags = $repo->findAllSortedByName();
        $isTagUsed = [];

        foreach ($tags as $tag) {
            $isTagUsed[$tag->getId()] = $repo->isTagUsed($tag->getId());
        }

        return $this->render('tags/Gestion_Tags.html.twig', [
            'tags' => $tags,
            'message' => 'Gestion des Tags',
            'isTagUsed' => $isTagUsed,
        ]);
    }

    // *********************************************************************************************************************
    //************** CREATE  *******************//
    // *********************************************************************************************************************

    #[Route('/Create_Tag', name: 'Create_Tag')]
    public function Create(TagsRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $tag = new Tags();
        $tags = $repo->findAllSortedByName();
        $isTagUsed = [];
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

        return $this->render('tags/Create_Tag.html.twig', [
            'tags' => $tags,
            'form' => $form,
            'message' => 'Gestion des Tags',
            'isTagUsed' => $isTagUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** UPDATE *******************//
    // *********************************************************************************************************************

    #[Route('/update_tags/{id}', name: 'update_tags')]
    public function Update(TagsRepository $repo, Request $request, EntityManagerInterface $manager, $id = null): Response
    {
        $tags = $repo->findAllSortedByName();
        $isTagUsed = [];

        foreach ($tags as $tag) {
            $isTagUsed[$tag->getId()] = $repo->isTagUsed($tag->getId());
        }
        $tag = $repo->find($id);

        $form = $this->createForm(TagsType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $manager->persist($tag);
            $manager->flush();

            return $this->redirectToRoute('Gestion_tags');
        }

        return $this->render('tags/Update_Tag.html.twig', [
            'tags' => $tags,
            'form' => $form,
            'message' => 'Gestion des Tags',
            'isTagUsed' => $isTagUsed,
        ]);
    }

    // *********************************************************************************************************************
    //*************** DELETE *******************//
    // *********************************************************************************************************************
    #[Route('/delete_Tag_pop_Up/{id}', name: 'delete_Tag_pop_Up')]
    public function Delete_Pop_Up(Tags $ta, TagsRepository $repo): Response
    {
        $tags = $repo->findAllSortedByName();
        $isTagUsed = [];

        foreach ($tags as $tag) {
            $isTagUsed[$tag->getId()] = $repo->isTagUsed($tag->getId());
        }

        return $this->render('tags/Delete_Tag.html.twig', [
            'ta' => $ta,
            'tags' => $tags,
            'message' => 'Gestion des Tags',
            'isTagUsed' => $isTagUsed,
        ]);
    }
    #[Route('/delete_Tag/{id}', name: 'delete_Tag')]
    public function Delete(Tags $ta, EntityManagerInterface $manager): Response
    {
        $manager->remove($ta);
        $manager->flush();
        return $this->redirectToRoute('Gestion_tags');
    }

}    




