<?php
/**
 * Created by PhpStorm.
 * User: aRosen_LN
 * Date: 02.06.2018
 * Time: 17:27
 */

namespace App\Helpers;

/**
 * Class Helper.
 *
 * @package App\Helpers
 */
class Helper
{
    /**
     * @return string
     */
    public static function getShortUrlPrefix(): string
    {
        return route('home');
    }

    /**
     * @param string $string
     * @return string
     */
    public static function clearString(string $string): string
    {
        return trim(mb_convert_encoding($string, 'UTF-8'));
    }
}