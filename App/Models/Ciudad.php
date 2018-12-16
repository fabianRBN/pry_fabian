<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Ciudad extends \Core\Model
{
    const TABLE = 'cat_ciudades';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }

    public static function findByCountry($pais)
    {   
        $ciudades = [];
        $c = static::query("SELECT * FROM {general}.{model} WHERE codigo_pais='$pais'");

        foreach ($c as $cc) {
            $ciudades[] = $cc->nombre;
        }

        return $ciudades;
    }

}
