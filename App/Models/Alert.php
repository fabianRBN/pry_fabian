<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;




class Alert extends \Core\Model
{
    const TABLE = 'tb_alertas';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model}");
    }
    
    public static function get($id,$tipo)
    {
        return static::query("SELECT a.*,CONCAT(u.nombre,' ',u.apellidos) as gestor,CONCAT(c.nombre,' ',c.apellidos) as cliente,CONCAT(uu.nombre,' ',uu.apellidos) as usuario,c.cliente as no_cliente FROM {cartera}.{model} as a LEFT JOIN {general}.tb_usuarios as u ON u.id=a.asesor LEFT JOIN {general}.tb_usuarios as uu ON uu.id=a.id_usuario LEFT JOIN {cartera}.tb_clientes as c ON c.id=a.id_cliente WHERE a.identificador=$id AND a.tipo='$tipo' ORDER BY a.fecha_creacion DESC");
    }
    
    public static function getUser($id,$tipo)
    {
        $user = Session::get('sivoz_auth')->id;

        return static::query("SELECT a.*,CONCAT(u.nombre,' ',u.apellidos) as gestor,CONCAT(c.nombre,' ',c.apellidos) as cliente,CONCAT(uu.nombre,' ',uu.apellidos) as usuario,c.cliente as no_cliente FROM {cartera}.{model} as a LEFT JOIN {general}.tb_usuarios as u ON u.id=a.asesor LEFT JOIN {general}.tb_usuarios as uu ON uu.id=a.id_usuario LEFT JOIN {cartera}.tb_clientes as c ON c.id=a.id_cliente WHERE a.identificador=$id AND a.tipo='$tipo' AND id_cliente=$user ORDER BY a.fecha_creacion DESC");
    }

    public static function read()
    {
        $user = Session::get('sivoz_auth');

        if($user->permiso == 7){
            return static::queryOneTime("UPDATE {cartera}.{model} SET leido=1 WHERE id_cliente=" . $user->id);
        }else{
            return static::queryOneTime("UPDATE {cartera}.{model} SET leido=1 WHERE id_usuario=" . $user->id);
        }
    }
    
    public static function byUser($all = false)
    {
        $user = Session::get('sivoz_auth');

        if($all == false){
            if($user->permiso == 7){
                return static::query("SELECT * FROM {cartera}.{model} WHERE id_cliente=" . $user->id . " AND leido=0 ORDER BY fecha_creacion DESC");
            }else{
                return static::query("SELECT * FROM {cartera}.{model} WHERE id_usuario=" . $user->id . " AND leido=0 ORDER BY fecha_creacion DESC");
            }
        }else{
            if($user->permiso == 7){
                return static::query("SELECT a.*,CONCAT(u.nombre,' ',u.apellidos) as gestor,CONCAT(c.nombre,' ',c.apellidos) as cliente,CONCAT(uu.nombre,' ',uu.apellidos) as usuario,c.cliente as no_cliente FROM {cartera}.{model} as a LEFT JOIN {general}.tb_usuarios as u ON u.id=a.asesor LEFT JOIN {general}.tb_usuarios as uu ON uu.id=a.id_usuario LEFT JOIN {cartera}.tb_clientes as c ON c.id=a.id_cliente WHERE a.id_cliente=$user->id ORDER BY a.fecha_creacion DESC");
            }else{
                return static::query("SELECT a.*,CONCAT(u.nombre,' ',u.apellidos) as gestor,CONCAT(c.nombre,' ',c.apellidos) as cliente,CONCAT(uu.nombre,' ',uu.apellidos) as usuario,c.cliente as no_cliente FROM {cartera}.{model} as a LEFT JOIN {general}.tb_usuarios as u ON u.id=a.asesor LEFT JOIN {general}.tb_usuarios as uu ON uu.id=a.id_usuario LEFT JOIN {cartera}.tb_clientes as c ON c.id=a.id_cliente WHERE a.id_usuario=$user->id ORDER BY a.fecha_creacion DESC");
            }
        }

    }

    public static function create($tipo,$id,$titulo,$comentario,$url,$identificador,$tipoID)
    {
       
        if($tipo == 'cliente'){
            return static::queryOneTime("INSERT INTO {cartera}.{model} (id_cliente,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $id .",'". $titulo ."','". $comentario ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
        }else{
            return static::queryOneTime("INSERT INTO {cartera}.{model} (id_usuario,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $id .",'". $titulo ."','". $comentario ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
        }
    }
    // Alerta a los usuarios seleccionados en la configuracion de la notificacion
    public static function crear($data, $url, $identificador, $tipoID, $id = null)
    {

      
      if($data->email_smtp==1){


            $from = "smartcloud@cntcloud.com";
            $to = $cliente->correo;
            //$subject = "CNT - ".$data->titulo;

            $subject = "CNT - Alerta usuarios configurados";


            $carrito = Carrito::getById($identificador)[0];
            $producto = Producto::findById($carrito->id_producto);
            $cliente = Cliente::findByID($carrito->id_cliente);
            $estatus = Estatus::findByIDs($data->id_estatus); 


            $headers = "From:" . $from;
            $headers .= " CC: smartcloud@cntcloud.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
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
                         <p><strong>Fecha de solicitud: </strong>'. $carrito->fecha_compra.' </p>
                         <p><strong>Cliente: </strong>'. $cliente->nombre.' </p>
                         <p><strong>Correo: </strong>'. $cliente->correo.' </p>
                         <p><strong>Estatus: </strong>'. $estatus->nombre.' </p>
                         <p><strong>Titulo: </strong>'. $data->titulo.' </p>
                         <p><strong>Comentario: </strong>'. $data->comentario.' </p>
    					</div>
                    </div>
                </div>

            </body>
            </html>';

            static::queryOneTime("INSERT INTO {cartera}.tb_correo (emisor,receptor,mensaje,cabezera) VALUES ('". $to ."','". $from ."','". $message ."','". $headers ."')");

            //mail($to,$subject,$message, $headers);

        } 

        if($id == null){
            if($data->id_permiso == 7){
                $clientes = Cliente::all();
    
                foreach($clientes as $cliente){
                    if($cliente->permiso == $data->id_permiso){
                        
                        return static::queryOneTime("INSERT INTO {cartera}.{model} (id_cliente,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $cliente->id .",'". $data->titulo ."','". $data->comentario ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
                    }
                }
            }else{
                $users = User::allPermisos();
    
                foreach($users as $user){
                    if($user->permiso == $data->id_permiso){
                        return static::queryOneTime("INSERT INTO {cartera}.{model} (id_usuario,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $user->id .",'". $data->titulo ."','". $data->comentario ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
                    }
                }
            }

          
        }else{
            if($data->id_permiso == 7){
                return static::queryOneTime("INSERT INTO {cartera}.{model} (id_cliente,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $id .",'". $data->titulo ."','". $data->comentario ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
            }else{
                return static::queryOneTime("INSERT INTO {cartera}.{model} (id_usuario,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $id .",'". $data->titulo ."','". $data->comentario ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
            }
           
        }
    }
    // Usuario seleccionado en el modal
    public static function crearNuevo($comment, $titulo, $url, $identificador, $tipoID, $id = null)
    {
        
        if($id != null){
            $from = Config::SENDER;
            
            //$subject = "CNT - ".$titulo;
            $subject = "CNT - Alerta al usuario Notificado";

            $usuario =  User::findByID($id);
    
            $carrito = Carrito::getById($identificador)[0];
            $producto = Producto::findById($carrito->id_producto);
            $cliente = Cliente::findByID($carrito->id_cliente);

            $to = $cliente->correo;
            
            $headers = "From:" . $from;
            $headers .= " CC: ".Config::SENDER."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
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
                        <p><strong>Fecha de solicitud: </strong>'. $carrito->fecha_compra.' </p>
                        <p><strong>Cliente: </strong>'. $cliente->nombre.' </p>
                        <p><strong>Correo: </strong>'. $cliente->correo.' </p>
                        <p><strong>Nombre de usuario notificado: </strong>'. $usuario->nombre.' </p>
                        <p><strong>Correo de Usuario notificado: </strong>'. $usuario->correo.' </p>
                    </div>
                    </div>
                </div>
    
            </body>
            </html>';
           // mail($to,$subject,$message, $headers);
           
           static::query("INSERT INTO {cartera}.tb_correo (emisor,receptor,mensaje,cabezera) VALUES ('". $to ."','". $from ."','". $message ."','". $headers ."')");

        }
       

        return static::queryOneTime("INSERT INTO {cartera}.{model} (id_usuario,titulo,comentario,url,asesor,identificador,tipo) VALUES (". $id .",'". $titulo ."','". $comment ."','". $url ."',". Session::get('sivoz_auth')->id .",". $identificador .",'". $tipoID ."')");
    }




}
