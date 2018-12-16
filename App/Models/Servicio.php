<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Servicio extends \Core\Model
{
    const TABLE = 'cat_servicios';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
    }
    public static function allWebsite()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
    }

    public static function findById($id)
    {
        return self::query("SELECT * FROM {cartera}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {cartera}.{model} SET nombre='". $data['nombre'] ."',precio=". str_replace('$','',str_replace(',','',$data['precio'])) .",forma_pago=". $data['forma_pago'] .",descripcion='". $data['descripcion'] ."' WHERE id=" . $data['id']);

        $cb(true);
    }

    public static function graph()
    {
        $dataset = [];
        $temp = [];
        $labels = [];
        $p = self::query("SELECT nombre FROM {cartera}.{model}");
        $d = self::query("SELECT COUNT(c.id) as total,p.nombre as servicio FROM {cartera}.tb_suscripciones as c INNER JOIN {cartera}.{model} as p ON p.id=c.id_servicio GROUP BY p.nombre");
        for($i = 0; $i < count($p); $i++){
            $labels[] = $p[$i]->nombre;
            $dataset[] = 0;
        }

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($labels); $j++){
                if($labels[$j] == $d[$i]->servicio){
                    $dataset[$j] = (int) $d[$i]->total;
                }
            }
        }

        return ['dataset' => $dataset, 'labels' => $labels];
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {cartera}.{model} (nombre,precio,forma_pago,descripcion) VALUES ('". $data['nombre'] ."','". str_replace('$','',str_replace(',','',$data['precio'])) ."',". $data['forma_pago'] .",'". $data['descripcion'] ."')");

        $servicio = self::query("SELECT * FROM {cartera}.{model} WHERE nombre='". $data['nombre'] ."' AND precio=" . str_replace('$','',str_replace(',','',$data['precio'])), [], self::FETCH_ONE);

        Estatus::cloneFlow('servicio',$servicio->id);

        $cb(true);
    }
}
