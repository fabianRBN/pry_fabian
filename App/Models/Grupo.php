<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Config;
use \Core\Session;


class Grupo extends \Core\Model
{
    const TABLE = 'cat_grupos';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model} ORDER BY orden");
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {general}.{model} SET nombre='". $data['nombre'] ."',activo=". $data['activo'] .",icono='". $data['icono'] ."',orden=". $data['orden'] .",permisos='". $data['permisos'] ."' WHERE id=" . $data['id']);

        $cb(true);
    }

    public static function findById($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }
    public static function getAll()
    {
        return static::query("SELECT *,(SELECT COUNT(id) FROM {general}.cat_menu WHERE grupo={general}.{model}.id) as rutas FROM {general}.{model} ORDER BY orden");
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (nombre,orden,icono,activo,permisos) VALUES ('". $data['nombre'] ."',". $data['orden'] .",'". $data['icono'] ."',". $data['activo'] .",'". $data['permisos'] . "')");

        $cb(true);
    }
}
