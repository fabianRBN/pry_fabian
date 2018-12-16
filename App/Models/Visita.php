<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Visita extends \Core\Model
{
    const TABLE = 'tb_visitas';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
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
    
}
