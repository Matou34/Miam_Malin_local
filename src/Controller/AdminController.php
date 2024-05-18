<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/backoffice', name: 'admin_backOffice')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashBoard.html.twig', [
            'title'=>'Dashboard'
        ]);
    }
}
