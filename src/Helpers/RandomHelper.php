<?php


namespace App\Helpers;


class RandomHelper
{
    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function generate(int $length = 10): string
    {
        $bytes = random_bytes(($length-($length%2))/2);
        return bin2hex($bytes);
    }
}