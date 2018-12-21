<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Gestion extends \Core\Model
{
    const TABLE = 'tb_gestiones';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
    }

    public static function filter($input)
    {
        if($input->codigo == 'todos'){
            return static::query("SELECT g.codigo,g.estatus,g.descripcion,CONCAT(u.nombre,' ',u.apellidos) as usuario,g.cartera,g.fecha FROM {cartera}.{model} as g INNER JOIN {general}.tb_usuarios as u ON g.usuario=u.id WHERE fecha >= '$input->fecha_inicio' AND fecha <= '$input->fecha_fin'");
        }else{
            return static::query("SELECT g.codigo,g.estatus,g.descripcion,CONCAT(u.nombre,' ',u.apellidos) as usuario,g.cartera,g.fecha FROM {cartera}.{model} as g INNER JOIN {general}.tb_usuarios as u ON g.usuario=u.id WHERE codigo='$input->codigo' AND fecha >= '$input->fecha_inicio' AND fecha <= '$input->fecha_fin'");
        }
    }
    public static function generate($input)
    {

        $data = [];
        $names = [];
        if($input->codigo == 'todos'){
            $data = static::query("SELECT g.codigo,g.estatus,g.descripcion,CONCAT(u.nombre,' ',u.apellidos) as usuario,g.cartera,g.fecha FROM {cartera}.{model} as g INNER JOIN {general}.tb_usuarios as u ON g.usuario=u.id WHERE fecha >= '$input->fecha_inicio' AND fecha <= '$input->fecha_fin'");
            $names = [
                'codigo' => 'Codigo',
                'estatus' => 'Estatus',
                'descripcion' => 'Descripcion',
                'usuario' => 'Usuario',
                'cartera' => 'Cartera',
                'fecha' => 'Fecha',
            ];
        }else if($input->codigo == 'REPORTE'){
            if($input->reporte == '1'){
                $data = static::query("SELECT CONCAT(u.nombre,' ',u.apellidos) as cliente,u.cliente as no_cliente,p.nombre as producto,cc.total,cc.ticket,cc.fecha_registro as fecha,cc.fecha_pago as fecha_p,cc.fecha_aprovisionamiento as fecha_a,cc.fecha_compra as fecha_c FROM {cartera}.tb_carrito as cc INNER JOIN {cartera}.cat_productos as p ON cc.id_producto=p.id INNER JOIN {cartera}.tb_clientes as u ON u.id=cc.id_cliente  WHERE cc.fecha_registro >= '$input->fecha_inicio' AND cc.fecha_registro <= '$input->fecha_fin'");
                $names = [
                    'cliente' => 'Cliente',
                    'no_cliente' => 'No. cliente',
                    'producto' => 'Producto',
                    'total' => 'Total',
                    'ticket' => 'No. Ticket',
                    'fecha' => 'Fecha',
                    'fecha_p' => 'Fecha Pago',
                    'fecha_a' => 'Fecha Aprovisionamiento',
                    'fecha_c' => 'Fecha Compra',
                ];
            }else if($input->reporte == '2'){
                $data = static::query("SELECT CONCAT(u.nombre,' ',u.apellidos) as cliente,u.cliente as no_cliente,p.nombre as producto,cc.total,cc.ticket,cc.fecha_registro as fecha,cc.fecha_pago as fecha_p,cc.fecha_aprovisionamiento as fecha_a,cc.fecha_compra as fecha_c,e.nombre as estatus FROM {cartera}.tb_carrito as cc INNER JOIN {cartera}.cat_productos as p ON cc.id_producto=p.id INNER JOIN {cartera}.tb_clientes as u ON u.id=cc.id_cliente INNER JOIN {general}.cat_estatus as e ON e.id=cc.estatus  WHERE cc.fecha_registro >= '$input->fecha_inicio' AND cc.fecha_registro <= '$input->fecha_fin'");
                $names = [
                    'cliente' => 'Cliente',
                    'no_cliente' => 'No. cliente',
                    'producto' => 'Producto',
                    'total' => 'Total',
                    'ticket' => 'No. Ticket',
                    'fecha' => 'Fecha',
                    'fecha_p' => 'Fecha Pago',
                    'fecha_a' => 'Fecha Aprovisionamiento',
                    'fecha_c' => 'Fecha Compra',
                    'estatus' => 'Estado',
                ];
            }else if($input->reporte == '3'){
                $data = static::query("SELECT CONCAT(u.nombre,' ',u.apellidos) as cliente,u.cliente as no_cliente,p.nombre as producto,cc.total,cc.ticket,cc.fecha_registro as fecha,cc.fecha_pago as fecha_p,cc.fecha_aprovisionamiento as fecha_a,cc.fecha_compra as fecha_c,e.nombre as estatus FROM {cartera}.tb_carrito as cc INNER JOIN {cartera}.cat_productos as p ON cc.id_producto=p.id INNER JOIN {cartera}.tb_clientes as u ON u.id=cc.id_cliente INNER JOIN {general}.cat_estatus as e ON e.id=cc.estatus  WHERE cc.fecha_registro >= '$input->fecha_inicio' AND cc.fecha_registro <= '$input->fecha_fin' AND e.id=5");
                $names = [
                    'cliente' => 'Cliente',
                    'no_cliente' => 'No. cliente',
                    'producto' => 'Producto',
                    'total' => 'Total',
                    'ticket' => 'No. Ticket',
                    'fecha' => 'Fecha',
                    'fecha_p' => 'Fecha Pago',
                    'fecha_a' => 'Fecha Aprovisionamiento',
                    'fecha_c' => 'Fecha Compra',
                    'estatus' => 'Estado',
                ];
            }else if($input->reporte == '4'){
                $data = static::query("SELECT CONCAT(u.nombre,' ',u.apellidos) as cliente,u.cliente as no_cliente,p.nombre as producto,cc.total,cc.ticket,cc.fecha_registro as fecha,cc.fecha_pago as fecha_p,cc.fecha_aprovisionamiento as fecha_a,cc.fecha_compra as fecha_c,e.nombre as estatus FROM {cartera}.tb_carrito as cc INNER JOIN {cartera}.cat_productos as p ON cc.id_producto=p.id INNER JOIN {cartera}.tb_clientes as u ON u.id=cc.id_cliente INNER JOIN {general}.cat_estatus as e ON e.id=cc.estatus  WHERE cc.fecha_registro >= '$input->fecha_inicio' AND cc.fecha_registro <= '$input->fecha_fin' AND e.id=5");
                $names = [
                    'cliente' => 'Cliente',
                    'no_cliente' => 'No. cliente',
                    'producto' => 'Producto',
                    'total' => 'Total',
                    'ticket' => 'No. Ticket',
                    'fecha' => 'Fecha',
                ];
            }
        }else{
            $data = static::query("SELECT g.codigo,g.estatus,g.descripcion,CONCAT(u.nombre,' ',u.apellidos) as usuario,g.cartera,g.fecha FROM {cartera}.{model} as g INNER JOIN {general}.tb_usuarios as u ON g.usuario=u.id WHERE codigo='$input->codigo' AND fecha >= '$input->fecha_inicio' AND fecha <= '$input->fecha_fin'");

            $names = [
                'codigo' => 'Codigo',
                'estatus' => 'Estatus',
                'descripcion' => 'Descripcion',
                'usuario' => 'Usuario',
                'cartera' => 'Cartera',
                'fecha' => 'Fecha',
            ];
        }

        return ['data' => $data, 'names' => $names];
    }

    public static function create($codigo,$estatus,$descripcion)
    {
        return static::queryOneTime("INSERT INTO {cartera}.{model} (codigo,estatus,descripcion,usuario,cartera) VALUES (?,?,?,?,?)", [
            $codigo,
            $estatus,
            $descripcion,
            Session::get('sivoz_auth')->id,
            Config::DB_NAME
        ]);
    }

    public static function today()
    {
        return static::query("SELECT g.codigo,g.estatus,g.descripcion,CONCAT(u.nombre,' ',u.apellidos) as usuario,g.cartera,g.fecha FROM {cartera}.{model} as g INNER JOIN {general}.tb_usuarios as u ON g.usuario=u.id WHERE fecha >= '" . date('Y-m-d') . "'");
    }
}
