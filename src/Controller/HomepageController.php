<?php

namespace App\Controller;

use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(): Response
    {
        // Recupération d'un parametre du fichier services.yaml
        // dd( $this->getParameter('available_locales'));

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
