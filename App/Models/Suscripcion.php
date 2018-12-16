<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Config;
use \Core\Session;


class Suscripcion extends \Core\Model
{
    const TABLE = 'tb_suscripciones';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model} ORDER BY orden");
    }

    public static function findByID($id)
    {

        $carrito = self::query("SELECT * FROM {cartera}.{model} WHERE id=$id",[],self::FETCH_ONE);
        $carrito->estatus_data = self::query("SELECT * FROM {general}.cat_estatus WHERE tipo = 'servicio' AND codigo = " . $carrito->estatus, [], self::FETCH_ONE);

        $es = Estatus::processFind($carrito->id_servicio,$carrito->estatus_data->id, 'servicio');
        echo $es;
        $carrito->consecutivos = self::query("SELECT * FROM {general}.cat_estatus WHERE tipo = 'servicio' AND id IN(".$es.")");
        $carrito->producto = self::query("SELECT * FROM {cartera}.cat_servicios WHERE id=" . $carrito->id_servicio,[],self::FETCH_ONE);
        $carrito->cliente = self::query("SELECT * FROM {cartera}.tb_clientes WHERE id=" . $carrito->id_cliente,[],self::FETCH_ONE);

        return $carrito;

    }

    public static function changeEstatus($id,$comment,$estatus,$fecha_aprovisionamiento = false,$cb)
    {
        self::queryOneTime("UPDATE {cartera}.{model} SET estatus=$estatus WHERE id=$id");
        $servicio = self::query("SELECT * FROM {cartera}.{model} WHERE id=$id",[],self::FETCH_ONE);

        Notificacion::send('operacion/suscripcion?id=' . $id,$estatus,'servicio',$servicio->id,'servicio');

        Alert::create('cliente',$servicio->id_cliente,'Cambio de estatus de suscripcion',$comment,'administracion/servicio?id=' . $id,$servicio->id,'servicio');
        $cb(true);
    }

    public static function ventasUltimosMeses($m)
    {
        $firstMonht = date('m') - $m + 1;
        $data = [];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labels = [];
        $dataset = [];


        for($i = $firstMonht; $i <= date('m'); $i++){
            $labels[] = $months[$i - 1];
            $data[] = ['mes' => $i, 'total' => 0, 'nombre' => $months[$i - 1]];
        }

        $date = date("Y-m-d", strtotime("-$m months"));
        $now = date('Y-m-d', strtotime("+1 days"));

        $d = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro)");

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data); $j++){
                if($d[$i]->mes == $data[$j]['mes']){
                    $data[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        for($i = 0; $i < count($data); $i++){
            $dataset[] = $data[$i]['total'];
        }

        return ['dataset' => $dataset, 'labels' => $labels];
    }

    public static function allAdmin()
    {
        return self::query("SELECT v.id,v.fecha_inicio,v.fecha_fin,p.precio as total,v.estatus,p.nombre as servicio,CONCAT(c.nombre,' ',c.apellidos) as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_servicios as p ON p.id=v.id_servicio");
    }

    public static function active()
    {
        return true;
        $suscripcion = self::query("SELECT * FROM {cartera}.{model} WHERE id_cliente=" . Session::get('sivoz_auth')->id, [], self::FETCH_ONE);

        if($suscripcion->estatus == 1 || $suscripcion->estatus == 6){
            return true;
        }else{
            return false;
        }
    }

    public static function mine()
    {
        return self::query("SELECT * FROM {cartera}.{model} WHERE id_cliente=" . Session::get('sivoz_auth')->id, [], self::FETCH_ONE);
    }

    public static function mines()
    {
        $productos = self::query("SELECT * FROM {cartera}.{model} WHERE id_cliente=" . Session::get('sivoz_auth')->id);

        foreach($productos as $producto){
            $producto->producto = self::query("SELECT * FROM {cartera}.cat_servicios WHERE id=" . $producto->id_servicio, [], self::FETCH_ONE);
        }

        return $productos;
    }

    public static function add($id, $cb)
    {
        $cliente = Session::get('sivoz_auth')->id;
        $servicio = self::query("SELECT * FROM {cartera}.cat_servicios WHERE id=$id", [], self::FETCH_ONE);
        $fechaIn = date('Y-m-d');
        $fechaFin = date('Y-m-d');
        $estatus = 0;
        switch ($servicio->forma_pago) {
            case 1:
                $fechaFin =  date('Y-m-d');
                break;
            case 2:
                $fechaFin =  date('Y-m-d', strtotime($fechaIn. ' + 1 days'));
                break;
            case 3:
                $fechaFin =  date('Y-m-d', strtotime($fechaIn. ' + 7 days'));
                break;
            case 4:
                $q = date('d', strtotime($fechaIn));
                if($q < 15){
                    $q = date('Y-m-d', strtotime($fechaIn. ' + '. (15 - $q) .' days'));
                }else{
                    $q = date('Y-m-d', strtotime($fechaIn. ' + '. (31 - $q) .' days'));
                }
                $fechaFin =  $q;
                break;
            case 5:
                $fechaFin =  date('Y-m-d', strtotime($fechaIn. ' + 1 months'));
                break;
            case 6:
                $fechaFin =  date('Y-m-d', strtotime($fechaIn. ' + 1 year'));
                break;
        }

        self::queryOneTime("INSERT INTO {cartera}.{model} (id_cliente,id_servicio,fecha_inicio,fecha_fin,estatus) VALUES ($cliente,$id,'$fechaIn','$fechaFin',$estatus)");

        $last = self::query("SELECT * FROM {cartera}.{model} ORDER BY fecha_registro DESC LIMIT 1 ",[],self::FETCH_ONE);

        Notificacion::send('operacion/suscripcion?id=' . $last->id,$estatus,'servicio',$last->id,'servicio');

        $cb(true, $last->id);
    }
}
