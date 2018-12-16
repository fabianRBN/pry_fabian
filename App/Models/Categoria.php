<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Categoria extends \Core\Model
{
    const TABLE = 'cat_categorias';

    public static function all()
    {
        return static::query("SELECT c.id,c.nombre,(SELECT COUNT(id) FROM {cartera}.cat_productos WHERE categoria=c.id) productos FROM {cartera}.{model} as c");
    }

    public static function findBy($id)
    {
        $categorias = self::query("SELECT c.id,c.nombre,(SELECT COUNT(id) FROM {cartera}.cat_productos WHERE categoria=c.id) productos FROM {cartera}.{model} as c WHERE id='$id'", [], self::FETCH_ONE);

        return $categorias;
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {cartera}.{model} SET nombre='". strtoupper($data['nombre']) ."' WHERE id=" . $data['id']);

        $cb(true);
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {cartera}.{model} (nombre) VALUES ('". strtoupper($data['nombre']) ."')");

        $cb(true);
    }
}
