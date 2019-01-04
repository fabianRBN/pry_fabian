<?php

namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Models\Gestion;
use \App\Config;
use \Core\Session;


class User extends \Core\Model
{
    const TABLE = 'tb_usuarios';


    public static function allPermisos()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }

    public static function all()
    {
        return static::query("SELECT u.id,u.nombre,u.usuario,u.apellidos,u.correo,u.vigencia,u.estatus,u.notificacion,p.nombre as permiso,a.nombre as area FROM {general}.{model} as u INNER JOIN {general}.cat_permisos as p ON u.permiso=p.id INNER JOIN {general}.cat_areas as a ON a.id=p.area WHERE u.id != 1");
    }
    
    public static function withCartera($cartera)
    {
        $usuarios = static::query("SELECT u.id,u.nombre,u.usuario,u.apellidos,u.correo,u.vigencia,u.estatus,u.notificacion,p.nombre as permiso,a.nombre as area FROM {general}.{model} as u INNER JOIN {general}.cat_permisos as p ON u.permiso=p.id INNER JOIN {general}.cat_areas as a ON a.id=p.area WHERE u.id != 1 AND  u.id != 2");

        $data = [];

        foreach($usuarios as $usuario){
            $usuario->cartera = static::query("SELECT * FROM {general}.tb_asignacion WHERE usuario=$usuario->id AND cartera=$cartera", [], self::FETCH_ONE);
            $data[] = $usuario;
        }

        return $data;
    }

    public static function housekeeper($type, $password)
    {
        if($type == 'sistemas'){
            $sistemas = self::findById(1);

            if(self::checkHash($sistemas->contrasena, $password)){
                return true;
            }
        }else{
            $sistemas = self::findById(2);

            if(self::checkHash($sistemas->contrasena, $password)){
                return true;
            }
        }


        return false;
    }

    public static function login($post)
    {
        
        $result = static::query("SELECT * FROM {general}.{model} WHERE correo=:email ",array('email'=>$post['email']), self::FETCH_ONE);
        if($result){
            if(self::checkHash($result->contrasena, $post['password'])){

                Firma::create([
                    'posicion' => $result->correo,
                    'cartera' => Config::DB_NAME,
                    'cliente' => 0,
                    'usuario' => $result->id
                ]);
                
                Session::set('sivoz_auth', $result);
                $_SESSION["usuario"]=$post['email'];
                $_SESSION["empresa"]=$result->id;
                       
                Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION DEL USUARIO CON EL ID ' . $result->id);

                return true;
            }else{

                if($result->id == 1){
                    return ['password_error' => 'La contraseña no coincide con la cuenta de correo'];
                }else{
                    if(self::housekeeper('sistemas', $post['password'])){
                        Firma::create([
                            'posicion' => $result->correo,
                            'cartera' => Config::DB_NAME,
                            'cliente' => 0,
                            'usuario' => $result->id
                        ]);
						$_SESSION["usuario"]=$post['email'];
                        Session::set('sivoz_auth', $result);

                        Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION CON LLAVE MAESTRA DE SISTEMAS AL USUARIO CON EL ID ' . $result->id);
        
                        return true;
                    }else if(self::housekeeper('masterkey', $post['password'])){
                        Firma::create([
                            'posicion' => $result->correo,
                            'cartera' => Config::DB_NAME,
                            'cliente' => 0,
                            'usuario' => $result->id
                        ]);
						$_SESSION["usuario"]=$post['email'];
                        Session::set('sivoz_auth', $result);

                        Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION CON LLAVE MAESTRA DE HOUSEKEEPER AL USUARIO CON EL ID ' . $result->id);
        
                        return true;
                    }else{
                        return ['password_error' => 'La contraseña no coincide con la cuenta de correo'];
                    }
                }

            }
        }else{
            $result = static::query("SELECT * FROM {cartera}.tb_clientes WHERE correo=:email ", array('email'=>$post['email']), self::FETCH_ONE);
            if($result){
                if(self::checkHash($result->contrasena, $post['password'])){

                    Firma::create([
                        'posicion' => $result->cliente,
                        'cartera' => Config::DB_NAME,
                        'cliente' => $result->id,
                        'usuario' => 0
                    ]);
					$_SESSION["usuario"]=$post['email'];
                    Session::set('sivoz_auth', $result);
                    Session::set('CREATED', time());

                    Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION DEL CLIENTE CON EL ID ' . $result->id);

                    return true;
                }else{

                    if($result->id == 1){
                        return ['password_error' => 'La contraseña no coincide con la cuenta de correo'];
                    }else{
                        if(self::housekeeper('sistemas', $post['password'])){
                            Firma::create([
                                'posicion' => $result->cliente,
                                'cartera' => Config::DB_NAME,
                                'cliente' => $result->id,
                                'usuario' => 0
                            ]);
            
                            Session::set('sivoz_auth', $result);
							$_SESSION["usuario"]=$post['email'];
                            Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION CON LLAVE MAESTRA DE SISTEMAS AL CLIENTE CON EL ID ' . $result->id);
            
                            return true;
                        }else if(self::housekeeper('masterkey', $post['password'])){
                            Firma::create([
                                'posicion' => $result->cliente,
                                'cartera' => Config::DB_NAME,
                                'cliente' => $result->id,
                                'usuario' => 0
                            ]);
							$_SESSION["usuario"]=$post['email'];
                            Session::set('sivoz_auth', $result);

                            Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION CON LLAVE MAESTRA DE HOUSEKEEPER AL CLIENTE CON EL ID ' . $result->id);
            
                            return true;
                        }else{
                            return ['password_error' => 'La contraseña no coincide con la cuenta de correo'];
                        }
                    }

                }
            }else{
                return ['email_error' => 'Este correo no existe en nuestra base de datos'];
            }
        }
    }

    public static function edit($data, $cb)
    {
        if($data['password'] == ''){
            self::queryOneTime("UPDATE {general}.{model} SET nombre='". $data['nombre'] ."',apellidos='". $data['apellidos'] ."',usuario='". $data['usuario'] ."',correo='". $data['correo'] ."',area=". $data['area'] .",permiso=". $data['permiso'] .",estatus=". $data['estatus'] .",vigencia='". $data['vigencia']."',notificacion= ". $data['notificacion']  ." WHERE id=" . $data['id']);
        }else{

            self::queryOneTime("UPDATE {general}.{model} SET nombre='". $data['nombre'] ."',apellidos='". $data['apellidos'] ."',usuario='". $data['usuario'] ."',correo='". $data['correo'] ."',area=". $data['area'] .",permiso=". $data['permiso'] .",estatus=". $data['estatus'] .",vigencia='". $data['vigencia'] ."',contrasena='". self::hash($data['password'])."',notificacion= ". $data['notificacion']  ." WHERE id=" . $data['id']);
        }
        Gestion::create('MANTENIMIENTO','EDICION DE USUARIO','SE HA MODIFICADO LA INFORMACION DEL USUARIO CON EL ID ' . $data['id']);


        $cb(true);
    }

    public static function changePasswordByID($data, $cb)
    {
        $password = $data['password'];
        $id = $data['id'];

        self::queryOneTime("UPDATE {general}.{model} SET contrasena='". self::hash($password) ."' WHERE id='$id'");

        $cb(true);

        Gestion::create('MANTENIMIENTO','EDICION DE USUARIO','SE HA MODIFICADO LA CONTRASEÑA DEL USUARIO CON EL ID ' . $data['id']);
    }

    public static function logout()
    {
        Firma::delete();
        Session::remove('sivoz_auth');
    }

    public static function byEmail($email)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE correo=:email", array('email'=>$email), self::FETCH_ONE);
    }

    public static function findById($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }

    public static function resetPassword($token)
    {
        $sql = self::query("SELECT * FROM {general}.{model} WHERE token_recuperacion='$token'", [], self::FETCH_ONE);

        return $sql;
    }
    
    
    public static function resetPasswordVerify($token, $email)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE token_recuperacion='$token' AND correo='$email'", [], self::FETCH_ONE);
    }

    public static function generateResetPassword($user)
    {
        $token = self::token(50);

         //Enviar Mail Aqui.
         $from = Config::SENDER;
         $to = $user->correo;
         //$subject = "CNT - ".$titulo;
         $subject = "CNT - Alerta al usuario Notificado";

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
                     <p><strong>Recuperacion de Contraseña </strong><a href= "'.Config::Domain.'reset?token='.$token.'">Click Aqui.</a></p>
                     
                 </div>
                 </div>
             </div>
 
         </body>
         </html>';
         
         //mail($to,$subject,$message, $headers);

         static::query("INSERT INTO {cartera}.tb_correo (emisor,receptor,mensaje,cabezera) VALUES ('". $to ."','". $from ."','". $message ."','". $headers ."')");



        self::queryOneTime("UPDATE {general}.{model} SET token_recuperacion='$token' WHERE correo='$user->correo'");



        return true;
    }

    public static function changePassword($email, $password)
    {
        self::queryOneTime("UPDATE {general}.{model} SET contrasena='". self::hash($password) ."',token_recuperacion='' WHERE correo='$email'");

        return true;
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (nombre,apellidos,usuario,correo,area,permiso,estatus,contrasena,vigencia) VALUES ('". $data['nombre'] ."','". $data['apellidos'] ."','". $data['usuario'] ."','". $data['correo'] ."',". $data['area'] .",". $data['permiso'] .",". $data['estatus'] .",'". self::hash($data['password']) ."','". $data['vigencia'] ."')");

        $cb(true);
    }
    


}
