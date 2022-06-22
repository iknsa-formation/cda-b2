<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LanguageExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction("select_language", [$this, 'doSelectLanguage'])
        ];
    }

    public function doSelectLanguage(): string
    {
        return "Select Lang !!!";
    }
}