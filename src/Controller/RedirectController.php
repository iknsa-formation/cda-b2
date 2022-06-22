<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): Response
    {
        // Recupération de la locale par defaut definit dans le fichier "service.yaml
        $locale = $this->getParameter('default_locale');

        // Redirection de l'utilisateur vers la route "Homepage" avec le partamètre de langue part defaut
        return $this->redirectToRoute('app_homepage', [
            '_locale' => $locale
        ]);
    }
}
