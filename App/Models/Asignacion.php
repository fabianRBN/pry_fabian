<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Asignacion extends \Core\Model
{
    const TABLE = 'tb_asignacion';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }

    public static function findByCartera($cartera)
    {
        return static::query("SELECT * FROM {general}.{model} WHERE cartera=" . $cartera);
    }

    public static function delete($cartera, $id)
    {
        return static::queryOneTime("DELETE FROM {general}.{model} WHERE cartera=$cartera AND usuario=$id");
    }

    public static function create($cartera, $id)
    {
        $sql = static::query("SELECT * FROM {general}.{model} WHERE cartera=$cartera AND usuario=$id", [], self::FETCH_ONE);
        if($sql){

        }else{
            return static::queryOneTime("INSERT INTO {general}.{model} (cartera,usuario) VALUES ($cartera,$id)");
        }
    }

}
