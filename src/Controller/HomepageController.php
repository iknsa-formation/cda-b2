<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_hommepage')]
    public function index(): Response
    {
        return $this->render('hommepage/index.html.twig', [
            'controller_name' => 'HommepageController',
        ]);
    }
}
