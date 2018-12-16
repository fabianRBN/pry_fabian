<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Cartera extends \Core\Model
{
    const TABLE = 'tb_cartera';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }
    
    public static function findByID($cartera)
    {
        return static::query("SELECT * FROM {general}.{model} WHERE id=" . $cartera, [], self::FETCH_ONE);
    }

}
