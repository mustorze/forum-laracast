<?php

namespace App\Inspections;

use Exception;

/**
 * Class InvalidKeywords
 * @package App\Inspections
 */
class InvalidKeywords
{

    protected $keywords = [
        'yahoo costumer support'
    ];

    /**
     * @param $body
     * @return bool
     * @throws Exception
     */
    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam.');
            }
        }

        return true;
    }
}