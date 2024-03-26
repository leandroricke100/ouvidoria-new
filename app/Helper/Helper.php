<?php

namespace App\Helper;

class Helper
{
    public static function leftPad($str, $len = 3, $caracter = '0')
    {
        return str_pad($str, $len, $caracter, STR_PAD_LEFT);
    }

    public static function convertDate($data)
    {
        if (strlen($data) == 10)  return  date('d/m/Y', strtotime($data));
        return  date('d/m/Y H:i:s', strtotime($data));
    }

    public static function obterNomeMes($mes_numero)
    {
        $meses = array(
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        );


        if (isset($meses[$mes_numero])) {
            return $meses[$mes_numero];
        } else {
            return 'Mês Inválido';
        }
    }

    public static function slugfy($string, $divider = '-')
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
