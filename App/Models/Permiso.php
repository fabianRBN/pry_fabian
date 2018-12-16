<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Permiso extends \Core\Model
{
    const TABLE = 'cat_permisos';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }
    public static function getAll()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }

    public static function getAlls()
    {
        return static::query("SELECT p.nombre,p.id,(SELECT COUNT(id) FROM {general}.tb_usuarios as u WHERE u.permiso = p.id) as usuarios,a.nombre as area FROM {general}.{model} as p INNER JOIN {general}.cat_areas as a ON a.id=p.area");
    }

    public static function findBy($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {general}.{model} SET nombre='". strtoupper($data['nombre']) ."',area=". $data['area'] ." WHERE id=" . $data['id']);

        $cb(true);
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (nombre,area) VALUES ('". strtoupper($data['nombre']) ."',". $data['area'] .")");

        $cb(true);
    }
}
