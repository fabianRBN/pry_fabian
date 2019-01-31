<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Asignado extends \Core\Model
{
    const TABLE = 'cat_asignacion';

    public static function all()
    {
        return self::query("SELECT * FROM {general}.{model}");
    }

    public static function create($carrito, $estatus, $usuario)
    {
        self::query("INSERT INTO {general}.{model} (id_carrito, id_estatus, id_usuario) VALUES (".$carrito.",".$estatus.",".$usuario.")");
        return true;
    }

    public static function delete($id){
        self::query("DELETE FROM {general}.{model} WHERE id_carrito = ".$id." AND id_usuario = ".$_SESSION['sivoz_auth']->id);
    }


    public static function alldata($id){
        $asignados = static::query("SELECT * FROM {general}.{model} as a  WHERE a.id_carrito = ".$id);

        foreach($asignados as $asignado){

            $usuario = self::query("SELECT nombre FROM {general}.tb_usuarios WHERE id = ".$asignado->id_usuario)[0];
            $asignado->usuario = $usuario->nombre;
            $estatus = self::query("SELECT  nombre FROM {general}.cat_estatus WHERE tipo ='carrito' AND codigo = ".$asignado->id_estatus)[0];
            $asignado->estado = $estatus->nombre;
        }

        return $asignados;
    }
}