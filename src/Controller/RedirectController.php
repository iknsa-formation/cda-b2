<?php

namespace App\Controller;

use App\Service\GuessLocale;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
    public function redirectToLocale(GuessLocale $guessLocale): Response
    {
        $locale = null;

        // Deviner la mangue de l'utilisateur
        $guess = $guessLocale->fromBrowser();
        $guess = explode("-", $guess);

        // Controle que $guess[0] fait partie des locales disponibles
        $availableLocales = $this->getParameter('available_locales');
        if (preg_match("/".$availableLocales."/", $guess[0]))
        {
            $locale = $guess[0];
        }

        // Recupération de la locale par defaut definit dans le fichier "service.yaml
        if (!$locale)
        {
            $locale = $this->getParameter('default_locale');
        }

        // Redirection de l'utilisateur vers la route "Homepage" avec le partamètre de langue part defaut
        return $this->redirectToRoute('app_homepage', [
            '_locale' => $locale
        ]);
    }
}
