<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


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

        $from = "email@cntcloud.com";
      
        $to = "fabianRBN_95@hotmail.com";
        $carrito = Carrito::getById($identificador)[0];
        $producto = Producto::findById($carrito->id_producto);
        $cliente = Cliente::findByID($carrito->id_cliente);
        $estatus=  Estatus::findByIDElemento($e,$tipo);

        $message = '<!DOCTYPE html>
            <html>
            <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">

            </head>
            <body style="background-color: #fafafa; padding-bottom: 40px;  padding-top: 40px;">

                
                <div style=" width: 100%; " >
                    <div style="
                
                    background-color: #FFFF;
                    width: 70%;
                    height: 100px;
                    margin-left: auto;
                    margin-right: auto;
                    border: 2px solid;
                    border-bottom-color: rgb(218, 218, 218);
                    border-top-color: #FFFF;
                    border-left-color: #FFFF;
                    border-right-color: #FFFF;
                    ">
                    <div style="
                    width: 20%;
                    height: 80px;
                    margin: 20px;
                    text-align: right;
                float: left;">      <img src="https://smart.cntcloud.com/public/assets/img/cnt-logo.png" alt=""></div>
                <div style="
                    width: 60%;
                    height: 80px;
                    margin: 20px;
                    text-align: right;
                float: left;"> <h2 style="font-family: Arial, Helvetica, sans-serif;">Corporación Nacional de Telecomunicaciones</h2></div>       
                </div>
                </div>
                
                <div style=" width: 100%;">
                    <div style=" background-color: #FFFF;
                    width: 70%;
                    height: 500px;
                    margin: 0 auto; 
                    text-align: left;
                    ">
                    <br>
                    <div style="padding:5%"> 
                        
                        <p><strong>Producto: </strong>'. $producto->nombre.' </p>
                        <p><strong>Fecha de compra: </strong>'. $carrito->fecha_compra.' </p>
                        <p><strong>Cliente: </strong>'. $cliente->nombre.' </p>
                        <p><strong>Correo: </strong>'. $cliente->correo.' </p>
                        <p><strong>Estatus: </strong>'. $estatus->nombre.' </p>
                        
                        </div>
                    </div>
                </div>

            </body>
        </html>';
       //$subject = "CNT -".$producto->nombre;
       $subject = "CNT - Notificacion al cliente";
        $headers = "From:" . $from;
        $headers .= " CC: email@cntclopud.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        /* 
        $message = '<p><strong>Producto:</strong>'. $producto->nombre.' </p>';
        $message .= '<p><strong>Fecha de compra:</strong>'. $carrito->fecha_compra.' </p>';
        $message .= '<p><strong>Estado:</strong>'. $estatus->nombre.' </p>';
        $message .= '<p><strong>Cliente:</strong>'. $cliente->nombre.' </p>';
        $message .= '<p><strong>Cliente:</strong>'. $cliente->correo.' </p>';
         */
        //$to =  $cliente->correo;

       // mail($to,$subject,$message, $headers);

        static::query("INSERT INTO {cartera}.tb_correo (emisor,receptor,mensaje,cabezera) VALUES ('". $to ."','". $from ."','". $message ."','". $headers ."')");

        
        $notificaciones = self::allAlert();
        $estatus = Estatus::findByID($e,$tipo);
        foreach($notificaciones as $notificacion){
            if($notificacion->id_estatus == $estatus){
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

    public static function crear($data, $cb)
    {
        static::queryOneTime("INSERT INTO {cartera}.{model} (id_permiso,id_estatus,id_usuario,comentario,titulo,email_smtp) VALUES (". $data['id_permiso'] .",". $data['id_estatus'] .",'". $data['id_usuario'] ."','". $data['comentario'] ."','". $data['titulo'] ."','".$data['email_smtp']."')");

        $cb(true);
    }
    
    public static function edit($data, $cb)
    {
        static::queryOneTime("UPDATE {cartera}.{model} SET id_permiso=". $data['id_permiso'] .",id_estatus=". $data['id_estatus'] .",id_usuario='". $data['id_usuario'] ."',titulo='". $data['titulo'] ."',comentario='". $data['comentario'] ."',email_smtp=". $data['email_smtp'] ." WHERE id=" . $data['id']);

        $cb(true);
    }

    
}
