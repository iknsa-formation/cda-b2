<?php 
namespace App\Service;

class GuessLocale
{
    public function fromBrowser(): ?string
    {
        // Retrieve the string of accepted language
        $http_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        // Check if $http_accept_language is not empty to continue
        if (empty($http_accept_language)) return null;

        // Convert string into an array
        $http_accept_language = explode(",", $http_accept_language);

        // Split language and score
        foreach ($http_accept_language as $index => $value)
        {
            // Split language and score
            $value = explode(";", $value);

            // Define the language string
            $language = $value[0];

            // Define the score string
            $score = isset($value[1]) ? $value[1] : 1;

            // Retrieve the score number
            $score = (float) filter_var($score, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            // Redefine the original array
            $http_accept_language[$index] = [
                'language' => $language,
                'score' => $score,
            ];
        }

        // Apply a filter on the $http_accept_language to order by score
        uasort($http_accept_language, [$this, 'cmp']);

        // Reset index of $http_accept_language
        $http_accept_language = array_values($http_accept_language);

        // Check if language has a value
        if (!isset($http_accept_language[0]['language']) || empty($http_accept_language[0]['language']) )
            return null;

        return $http_accept_language[0]['language'];
    }

    private function cmp($a, $b) 
    {
        if ($a['score'] == $b['score']) 
        {
            return 0;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    }
}