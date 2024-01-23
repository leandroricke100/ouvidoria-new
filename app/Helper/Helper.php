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

    // public function someHideEmail($data)
    // {

    //     return  date('d/m/Y H:i:s', strtotime($data));
    // }
}
