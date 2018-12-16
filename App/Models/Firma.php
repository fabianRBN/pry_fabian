<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Config;
use \Core\Session;


class Firma extends \Core\Model
{
    const TABLE = 'tb_firmados';

    public static function all()
    {
        $data = [];
        $usuarios =  self::query("SELECT f.cartera,f.usuario,f.fecha,c.nombre as cartera_nombre,CONCAT(u.nombre,' ',u.apellidos) as usuario_nombre,'Usuario' as tipo FROM {general}.{model} as f INNER JOIN {general}.tb_usuarios as u ON u.id=f.usuario INNER JOIN {general}.tb_cartera as c ON c.id=f.cartera WHERE f.usuario != 0");
        $clientes =  self::query("SELECT f.cartera,f.cliente as usuario,f.fecha,c.nombre as cartera_nombre,CONCAT(u.nombre,' ',u.apellidos) as usuario_nombre,'Cliente' as tipo FROM {general}.{model} as f INNER JOIN {cartera}.tb_clientes as u ON u.id=f.cliente INNER JOIN {general}.tb_cartera as c ON c.id=f.cartera WHERE f.cliente != 0");


        foreach ($usuarios as $u) {
            $data[] = $u;
        }

        foreach ($clientes as $c) {
            $data[] = $c;
        }

        return $data;
    }

    public static function find($data)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE cartera=" . $data['cartera'] . " AND usuario=" . $data['usuario'], [], self::FETCH_ONE);
    }

    public static function cerrarSession($data)
    {
        if($data['tipo'] == 'usuario'){
            return self::queryOneTime("DELETE FROM {general}.{model} WHERE cartera=" . $data['cartera'] . " AND usuario=" . $data['usuario'] . " AND fecha='". $data['fecha'] ."'");
        }else{
            return self::queryOneTime("DELETE FROM {general}.{model} WHERE cartera=" . $data['cartera'] . " AND cliente=" . $data['usuario'] . " AND fecha='". $data['fecha'] ."'");
        }
    }

    public static function create($data)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (posicion,cartera,cliente,usuario) VALUES (:posicion,:cartera,:cliente,:usuario)", $data, self::FETCH_ONE);

        $firma = self::query("SELECT * FROM {general}.{model} WHERE posicion='" . $data['posicion']."'", [], self::FETCH_ONE);

        Session::set('sivoz_firma', $firma);

        return $firma;
    }

    public static function delete()
    {
        self::queryOneTime("DELETE FROM {general}.{model} WHERE posicion='" . Session::get('sivoz_firma')->posicion . "'");
        Session::remove('sivoz_firma');
    }

}
