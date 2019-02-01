<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Estatus;


class Variables extends \Core\Model
{
    const TABLE = 'cat_variables';

    public static function createmensajes($data,$cb){

        $result = self::query("SELECT * FROM {general}.{model} WHERE nombre = 'mensaje_".$data['id_estatus']."'");

        $error = true;
        
        if(count($result) == 0){
            self::query("INSERT INTO  {general}.{model}  (nombre,valor) VALUES ( 'mensaje_".$data['id_estatus']."','".$data['value']."')");

            $error = false;
            $mensaje = 'Registro completo';
        }else{
            $error = true;
            $mensaje = 'Ya existe regla registrada';
        }


        return $cb( array('error'=> $error , 'mensaje'=> $mensaje));

    }

    public static function editmensajes($nombre, $valor,$id){

        self::query("UPDATE {general}.{model} SET nombre = 'mensaje_".$nombre."' , valor='".$valor."'  WHERE id = ".$id );

        return true;
    }

    public static function mensajesall(){
        $mensajes =  self::query("SELECT * FROM {general}.{model} WHERE nombre LIKE 'mensaje_%' ");

        foreach($mensajes as $mensaje){
            $mensaje->estatus = Estatus::findByIDs( substr($mensaje->nombre, 8) )->nombre;
        }

        return $mensajes;
    }

    public static function getMensaje($id){
        $mensajes =  static::query("SELECT valor FROM {general}.{model} WHERE nombre = 'mensaje_".$id."'");

     
        return $mensajes;
    }

    public static function getestatus(){
        $mensajes =  self::query("SELECT * FROM {general}.{model} WHERE nombre = 'estado_aprov' ")[0];
        $mensaje = Estatus::findByIDs($mensajes->valor)->nombre;
        return $mensaje;
    }

    

    public static function setaprov($data, $cb){

        self::query("UPDATE {general}.{model} SET   valor='".$data['id_estatus']."'  WHERE nombre = 'estado_aprov'" );

        $error = false;
        $mensaje = 'Actualizado';
      
        return $cb( array('error'=> $error , 'mensaje'=> $mensaje));

     
    }

    public static function deletemensaje($data, $cb){

        self::query("DELETE FROM {general}.{model} WHERE id = ".$data['id'] );

        $error = false;
        $mensaje = 'Actualizado';
      
        return $cb( array('error'=> $error , 'mensaje'=> $mensaje));

    }

    public static function editproducto(){

        self::query("UPDATE {general}.{model} SET nombre = 'producto_".$nombre."' , valor='".$valor."'  WHERE id = ".$id );

        return true;
    }


  
}