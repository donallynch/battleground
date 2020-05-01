<?php

namespace App\Services;

/**
 * Class HashGenerator
 * @package App\Services
 */
class HashGenerator
{
    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomString($length = 40)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function number($length = 6)
    {
        $output = '';

        if ($length < 1) {
            return $output;
        }

        $characters = '0123456789';
        $charactersLength = strlen($characters);

        /* First digit must be greater than 0 */
        $output .= $characters[rand(1, $charactersLength - 1)];

        /* The rest of the digits can be anything */
        for ($i = 1; $i < $length; $i++) {
            $output .= $characters[rand(0, $charactersLength - 1)];
        }

        return $output;
    }
}

