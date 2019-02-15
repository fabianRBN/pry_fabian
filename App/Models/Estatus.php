<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Models\Gestion;
use \App\Config;
use \Core\Session;


class Estatus extends \Core\Model
{
    const TABLE = 'cat_estatus';

    public static function all()
    {
        return self::query("SELECT * FROM {general}.{model} ORDER BY tipo");
    }

    public static function allcarrito()
    {
        return self::query("SELECT * FROM {general}.{model} WHERE tipo ='carrito' ORDER BY tipo");
    }

    public static function findByID($estatus,$tipo)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE tipo='$tipo' AND codigo=$estatus",[],self::FETCH_ONE)->id;
    }

    public static function findByIDElemento($estatus,$tipo)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE tipo='$tipo' AND codigo=$estatus",[],self::FETCH_ONE);
    }
    
    public static function editVars($data, $cb)
    {
        self::queryOneTime("UPDATE {general}.{model} SET nombre='". $data['nombre'] ."',titulo='". $data['titulo'] ."',mensaje='". $data['mensaje'] ."' WHERE id=" . $data['id']);

        $cb();
    }

    public static function addNew($data, $cb)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (`tipo`, `nombre`, `titulo`, `mensaje`, `comentario`, `color`, `codigo`, `x`, `y`, `im`, `om`, `consecutivos`) VALUES ('".$data['tipo']."', '".$data['nombre']."', '".$data['titulo']."', '".$data['mensaje']."', '".$data['comentario']."', 'default', 0, 1000, 1000, 0, 0, '0')");

        $cb();
    }

    public static function findByIDs($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id=$id",[],self::FETCH_ONE);
    }

    public static function findByIDsCodigo($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE tipo='carrito'  AND codigo = $id",[],self::FETCH_ONE);
    }

    public static function flujo()
    {
        $data = [
            'productos' => self::query("SELECT * FROM {general}.{model} WHERE tipo='carrito'"),
            'servicios' => self::query("SELECT * FROM {general}.{model} WHERE tipo='servicio'"),
        ];

        return $data;
    }

    public static function processFind($id,$estatus, $tipo)
    {
        $flujo = self::query("SELECT * FROM {general}.cat_flujo WHERE oid=$id AND tipo='$tipo'",[],self::FETCH_ONE);
		echo 'prueba';
		echo $flujo->id;
        $x = explode('|',$flujo->flujo);
        $xs = [];
        foreach($x as $xx){
            $xxx = explode('__',$xx);
            $xsx = [];
            foreach($xxx as $xxxx){
                $xxxxx = explode(';',$xxxx);
                $index = $xxxxx[0];
                if(isset($xxxxx[1])){
                    $value = $xxxxx[1];
                }else{
                    $value = '';
                }
                $xsx[$index] = $value;
            }
            $xs[] = $xsx;
        }


        foreach($xs as $x){
            if($x['id'] == $estatus){
                return $x['consecutivos'];
            }
        }
    }

    public static function flujoEditor($id, $tipo)
    {
        $estatus = self::query("SELECT * FROM {general}.{model} WHERE tipo='$tipo'");
        $data = self::query("SELECT * FROM {general}.cat_flujo WHERE tipo='$tipo' AND oid=$id", [], self::FETCH_ONE);
        $response = [];
        $x = explode('|',$data->flujo);
        $xs = [];
        foreach($x as $xx){
            $xxx = explode('__',$xx);
            $xsx = [];
            foreach($xxx as $xxxx){
                $xxxxx = explode(';',$xxxx);
                $index = $xxxxx[0];
                if(isset($xxxxx[1])){
                    $value = $xxxxx[1];
                }else{
                    $value = '';
                }
                $xsx[$index] = $value;
            }
            $xs[] = $xsx;
        }
        return ['original' => self::query("SELECT * FROM {general}.{model} WHERE tipo='$tipo'"), 'new' => $xs];
    }

    public static function changeFLujo($id, $data, $tipo)
    {
        return self::queryOneTime("UPDATE {general}.cat_flujo SET flujo='$data' WHERE oid=$id AND tipo='$tipo'");
    }

    public static function cloneFlow($type,$id, $cloned = null)
    {
        if($cloned == null){
            $data = self::query("SELECT * FROM {general}.{model} WHERE tipo='$type'");
            $r = '';
            $count = 0;
            for($i = 0; $i < count($data); $i++){
               if($i == count($data) - 1){
                    $r .= 'id;' . $data[$i]->id . '__x;' . $data[$i]->x . '__y;' . $data[$i]->y . '__im;' . $data[$i]->im . '__om;' . $data[$i]->om . '__consecutivos;' . $data[$i]->consecutivos;
               }else{
                    $r .= 'id;' . $data[$i]->id . '__x;' . $data[$i]->x . '__y;' . $data[$i]->y . '__im;' . $data[$i]->im . '__om;' . $data[$i]->om . '__consecutivos;' . $data[$i]->consecutivos . '|';
               }
            }

            self::queryOneTime("INSERT INTO {general}.cat_flujo (oid,flujo,tipo) VALUES ($id,'". $r ."','$type')");

            return self::query("SELECT * FROM {general}.cat_flujo WHERE oid=$id AND tipo='$type'", [], self::FETCH_ONE);

        }else{
            $data = self::query("SELECT * FROM {general}.cat_flujo WHERE oid=$cloned AND tipo='$type'",[],self::FETCH_ONE);

            self::queryOneTime("UPDATE {general}.cat_flujo SET flujo='". $data->flujo ."'  WHERE oid=$id AND tipo='$type'",[],self::FETCH_ONE);
        }
    }

    public static function edit($id,$consecutivos,$x,$y)
    {
        return self::queryOneTime("UPDATE {general}.{model} SET x=$x,y=$y,consecutivos='$consecutivos' WHERE id=$id");
    }

    public static function calculate($estatus,$tipo)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE tipo='$tipo' AND codigo=$estatus",[],self::FETCH_ONE)->nombre;
    }
    
    public static function idcalculate($estatus)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE  id=$estatus",[],self::FETCH_ONE)->codigo;
    }
}
