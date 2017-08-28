<?php

namespace App\Rules;

use App\Inspections\Spam;

/**
 * Class SpamFree
 * @package App\Rules
 */
class SpamFree
{
    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return !resolve(Spam::class)->detect($value);
        } catch (\Exception $e) {
            return false;
        }
    }
}