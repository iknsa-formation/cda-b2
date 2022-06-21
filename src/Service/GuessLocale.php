<?php 
namespace App\Service;

class GuessLocale
{
    public function fromBrowser(): ?string
    {
        return "I Guess the locale from the browser of the user.";
    }
}