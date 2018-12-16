<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Sector extends \Core\Model
{
    const TABLE = 'cat_sectores';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
    }

}
