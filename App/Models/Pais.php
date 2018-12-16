<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Pais extends \Core\Model
{
    const TABLE = 'cat_paises';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }

    public static function nombres()
    {
        $d = [];
        $data = static::query("SELECT * FROM {general}.{model}");

        foreach ($data as $v) {
            $d[] = $v->nombre;
        }

        return $d;
    }
    
    public static function findCode($nombre)
    {
        return static::query("SELECT * FROM {general}.{model} WHERE nombre='$nombre'", [], self::FETCH_ONE)->codigo;
    }

}
