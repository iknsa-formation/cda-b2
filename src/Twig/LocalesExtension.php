<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Intl\Locales;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LocalesExtension extends AbstractExtension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales_switch', [$this, 'doLocalesSwitch'], ['is_safe' => ['html']]),
        ];
    }

    public function doLocalesSwitch()
    {
        // Recupère les langues definies dans le fichier services.yaml
        $available_locales = $this->container->getParameter('available_locales');

        // Déclaration du tableau de stockages des langue (code + nom)
        $locales = [];

        // Sur la liste des langues dispo...
        foreach ($available_locales as $locale)
        {
            // Recupération du code langue
            $code = $locale;

            // Recupération + formattage du nom de la langue
            $name = Locales::getName($locale, $locale);
            $name = ucfirst(strtolower($name));

            // Ajout des données de langues au tableau ^locales
            array_push($locales, [
                'code' => $code,
                'name' => $name,
            ]);
        }
        

        // Definition de la variable de stockage de la chaine de sortie
        $output = "<ul>\n";

        foreach ($locales as $locale)
        {
            $output.= "<li>";

            $output.= "<a href=\"#".$locale['code']."\">";
            $output.= $locale['name'];
            $output.= "</a>";

            $output.= "</li>\n";
        }

        $output.= "</ul>\n";


        return $output;
    }
}
