<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Menu extends \Core\Model
{
    const TABLE = 'cat_menu';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model} WHERE grupo != 7");
    }
    
    public static function getAll()
    {
        return static::query("SELECT m.nombre,m.id,m.permisos,m.ruta,m.controlador,m.accion,m.activo,m.nombre as grupo_nombre,m.grupo FROM {general}.{model} as m "."" );
    }

    public static function login()
    {
        return static::query("SELECT * FROM {general}.{model} WHERE grupo=7 OR grupo=11");
    }

    public static function findById($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }

    public static function view($grupo)
    {
        return static::query("SELECT * FROM {general}.{model} WHERE grupo=$grupo OR grupo=11 AND grupo != 0 AND grupo != 7");
    }

    public static function create($ruta, $cb)
    {
        static::queryOneTime("INSERT INTO {general}.{model} (activo,grupo,nombre,permisos,ruta,controlador,accion) VALUES (". $ruta['activo'] .",'". $ruta['grupo'] ."','". $ruta['nombre'] ."','". $ruta['permisos'] ."','". $ruta['ruta'] ."','". $ruta['controlador'] ."','". $ruta['accion'] ."')");

        $cb(true);
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {general}.{model} SET nombre='". $data['nombre'] ."',activo=". $data['activo'] .",ruta='". $data['ruta'] ."',controlador='". $data['controlador'] ."',permisos='". $data['permisos'] ."',accion='". $data['accion'] ."',grupo=". $data['grupo'] ." WHERE id=" . $data['id']);

        $cb(true);
    }
}
