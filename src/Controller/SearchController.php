<?php

namespace App\Controller;

use App\Repository\RecettesRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }


    #[Route('/handleSearch', name: 'handleSearch')]
    public function handleSearch(Request $request, RecettesRepository $repo)
    {
        $query = $request->request->get('form')['query'];
        if($query) {
            $articles = $repo->findArticlesByName($query);
        }
        return $this->render('search/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
