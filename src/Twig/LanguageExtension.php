<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\Environment;


class LanguageExtension extends AbstractExtension
{
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }


    public function getFunctions(): array
    {
        return [
            new TwigFunction("select_language", [$this, 'doSelectLanguage'])
        ];
    }

    public function doSelectLanguage(): string
    {
        return $this->environment->render('components/language/select.html.twig');
    }
}