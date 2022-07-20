<?php 
namespace App\Service;

class GetUniqueId
{
    public function getUniqueId()
    {
        return uniqid('rgpd-');
    }
}

/**
 * @todo 
 */
