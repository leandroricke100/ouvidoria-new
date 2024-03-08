<?php

namespace App\Helper;

class Helper
{
    public function leftPad($str, $len = 3, $caracter = '0')
    {
        return str_pad($str, $len, $caracter, STR_PAD_LEFT);
    }

    public function convertDate($data)
    {
        if (strlen($data) == 10)  return  date('d/m/Y', strtotime($data));
        return  date('d/m/Y H:i:s', strtotime($data));
    }

    public function slugfy($string, $divider = '-')
    {
        $string = mb_strtolower($string);

        // replace non letter or digits by divider
        $string = preg_replace('~[^\pL\d]+~u', $divider, $string);

        // transliterate
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);

        // remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);

        // trim
        $string = trim($string, $divider);

        // remove duplicate divider
        $string = preg_replace('~-+~', $divider, $string);

        // lowercase
        $string = strtolower($string);

        if (empty($string)) return 'n-a';

        $ultima = substr($string, -1);
        if ($ultima == '-') $string = substr($string, 0, -1);

        return $string;
    }

    // public function someHideEmail($data)
    // {

    //     return  date('d/m/Y H:i:s', strtotime($data));
    // }
}
