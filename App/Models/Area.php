<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Area extends \Core\Model
{
    const TABLE = 'cat_areas';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }
    
    public static function getAll()
    {
        return static::query("SELECT *,(SELECT COUNT(id) FROM {general}.cat_permisos as p WHERE p.area = {general}.{model}.id) as permisos FROM {general}.{model}");
    }

    public static function findBy($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {general}.{model} SET nombre='". strtoupper($data['nombre']) ."' WHERE id=" . $data['id']);

        $cb(true);
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (nombre) VALUES ('". strtoupper($data['nombre']) ."')");

        $cb(true);
    }
}
