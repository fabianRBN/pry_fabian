<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;
use \Core\Correo;



class Notificacion extends \Core\Model
{
    const TABLE = 'tb_notificaciones';

    public static function all()
    {
        return static::query("SELECT n.id,n.id_permiso,n.id_estatus,n.titulo,n.comentario,p.nombre as permiso,e.nombre as estatus,e.comentario as comentario FROM {cartera}.{model} as n INNER JOIN {general}.cat_permisos as p ON p.id=n.id_permiso INNER JOIN {general}.cat_estatus as e ON e.id=n.id_estatus");
    }
    
    public static function allAlert()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
    }

    public static function send($url, $e, $tipo, $identificador, $tipoID, $id = null)
    {
        $carrito = Carrito::getById($identificador)[0];
        $producto = Producto::findById($carrito->id_producto);
        $cliente = Cliente::findByID($carrito->id_cliente);
        $estat=  Estatus::findByIDElemento($e,$tipo);

        $notificaciones = self::allAlert();
        $estatus = Estatus::findByID($e,$tipo);
        foreach($notificaciones as $notificacion){
            if($notificacion->id_estatus == $estatus){

                if($notificacion->email_smtp_cliente == 1){
                    $from = Config::SENDER;
                
                    
                    

                    $to = $cliente->correo;

                    $content = '         
                        <p><strong>Producto: </strong>'. $producto->nombre.' </p>
                        <p><strong>Fecha de compra: </strong>'. $carrito->fecha_compra.' </p>
                        <p><strong>Cliente: </strong>'. $cliente->nombre.' </p>
                        <p><strong>Correo: </strong>'. $cliente->correo.' </p>
                        <p><strong>Estatus: </strong>'. $estat->nombre.' </p>
                    ';
                    $subject = "CNT -".$producto->nombre;
                    //$subject = "CNT - Notificacion al cliente";
                    $headers = "From:" . $from;
                    $headers .= " CC: ".Config::SENDER."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                    $message =  Correo::buildEmail();
                    $message = str_replace("%body%", $content, $message);
                    mail($to,$subject,$message, $headers);
                    
                    //static::query("INSERT INTO {cartera}.tb_correo (emisor,receptor,mensaje,cabezera) VALUES ('". $to ."','". $from ."','". $message ."','". $headers ."')");

                
                }



                if($notificacion->id_usuario == '0'){
                    Alert::crear($notificacion, $url, $identificador, $tipoID, $id);
                }else{
                    foreach(explode(',',$notificacion->id_usuario) as $uid){
                        Alert::crear($notificacion, $url, $identificador, $tipoID, $uid);
                    }
                }
            }
        }

    }


    public static function findByID($id)
    {
        return static::query("SELECT * FROM {cartera}.{model} WHERE id=$id", [], self::FETCH_ONE);
    }
    public static function findByIDestatus($id)
    {
        return static::query("SELECT * FROM {cartera}.{model} WHERE id_estatus=$id", [], self::FETCH_ONE);
    }

    public static function crear($data, $cb)
    {
        static::queryOneTime("INSERT INTO {cartera}.{model} (id_permiso,id_estatus,id_usuario,comentario,titulo,email_smtp,email_smtp_cliente) VALUES (". $data['id_permiso'] .",". $data['id_estatus'] .",'". $data['id_usuario'] ."','". $data['comentario'] ."','". $data['titulo'] ."','".$data['email_smtp']."','".$data['email_smtp_cliente']."')");

        $cb(true);
    }
    
    public static function edit($data, $cb)
    {
        static::queryOneTime("UPDATE {cartera}.{model} SET id_permiso=". $data['id_permiso'] .",id_estatus=". $data['id_estatus'] .",id_usuario='". $data['id_usuario'] ."',titulo='". $data['titulo'] ."',comentario='". $data['comentario'] ."',email_smtp=". $data['email_smtp'] .",email_smtp_cliente=".$data['email_smtp_cliente']." WHERE id=" . $data['id']);

        $cb(true);
    }

    
}
