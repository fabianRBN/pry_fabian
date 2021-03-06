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
use \Core\Correo;


class Cliente extends \Core\Model
{
    const TABLE = 'tb_clientes';

    public static function login($post)
    {
        $result = static::query("SELECT * FROM {cartera}.{model} WHERE correo='". $post['correo'] ."'", [], self::FETCH_ONE);
        if($result){
            if(self::checkHash($result->contrasena, $post['password'])){

                Firma::create([
                    'posicion' => $result->cliente,
                    'cartera' => Config::DB_NAME,
                    'usuario' => 0,
                    'cliente' => $result->id
                ]);
    
                Session::set('sivoz_auth', $result);
                $_SESSION["usuario"]=$post['correo'];
                $_SESSION["empresa"]=$result->id;
                Gestion::create('ACCESO','INICIO DE SESION','INICIO DE SESION DEL CLIENTE CON EL ID ' . $result->id);

                return true;
            }
            
        }

        return false;
    }

    public static function findByID($id)
    {
        $client = self::query("SELECT * FROM {cartera}.{model} WHERE id=$id", [], self::FETCH_ONE);

        $client->productos = self::query("SELECT * FROM {cartera}.tb_carrito WHERE id_cliente=$client->id");

        $client->tipo = self::query("SELECT * FROM {cartera}.cat_tipo_cliente WHERE id=$client->tipo_cliente", [], self::FETCH_ONE);

        $client->sector = self::query("SELECT * FROM {cartera}.cat_sectores WHERE id=$client->sector", [], self::FETCH_ONE);

        return $client;
    }

    public static function byEmail($email)
    {
        return self::query("SELECT * FROM {cartera}.{model} WHERE correo=:email", array('email'=>$email), self::FETCH_ONE);
    }

    public static function emailgroup($email)
    { 
        $email = explode('@',$email)[1];
        $extension = array('icloud.com','gmail.com','hotmail.com');
        if(in_array($email,$extension)){
            return true;
        }else{
            return false;
        }
    }
    public static function byEmaillike($email)
    {
        $email = explode('@',$email)[1];
        return self::query("SELECT * FROM {cartera}.{model} WHERE correo like '%".$email."'", [], self::FETCH_ONE);
    }

    public static function emailvalido($email){

        $email = explode('@',$email)[1];

        $emaildb = self::query("SELECT * FROM {cartera}.{model} WHERE correo like '%".$email."'", [], self::FETCH_ONE);

        $emailgr = array('icloud.com','gmail.com','hotmail.com');

        if(in_array($email,$emailgr)){
            return true;
        }else if($emaildb){
            return false;
        }else{
            return true;
        }

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

            $message =  Correo::buildEmail();
            $content = '<p><strong>Recuperación de Contraseña </strong><a href= "'.Config::Domain.'reset?token='.$token.'">Click Aqui.</a></p>';
            $message = str_replace("%body%", $content, $message);
            mail($to,$subject,$message, $headers);

           // static::query("INSERT INTO {cartera}.tb_correo (emisor,receptor,mensaje,cabezera) VALUES ('". $to ."','". $from ."','". $message ."','". $headers ."')");

        self::queryOneTime("UPDATE {cartera}.{model} SET token_recuperacion='$token' WHERE correo='$user->correo'");

        return true;
    }

    public static function changePassword($email, $password)
    {
        self::queryOneTime("UPDATE {cartera}.{model} SET contrasena='". self::hash($password) ."',token_recuperacion='' WHERE correo='$email'");

        return true;
    }
    
    public static function resetPassword($token)
    {
        $sql = self::query("SELECT * FROM {cartera}.{model} WHERE token_recuperacion='$token'", [], self::FETCH_ONE);

        return $sql;
    }
    
    public static function resetPasswordVerify($token, $email)
    {
        return self::query("SELECT * FROM {cartera}.{model} WHERE token_recuperacion='$token' AND correo='$email'", [], self::FETCH_ONE);
    }


    public static function create($data)
    {

        
        foreach ($data as $key => $value) {
            if($key != 'password'){
                $data[$key] = htmlspecialchars($value, ENT_QUOTES,"UTF-8");
            }
        }

        self::queryOneTime("INSERT INTO {cartera}.{model} (nombre,apellidos,correo,permiso,estatus,pais,ciudad,contrasena,empresa,telefono,direccion,tipo_cliente,sector,ruc) VALUES ('". $data['nombre'] ."','". $data['apellidos'] ."','". $data['correo'] ."',7,0,'". $data['pais'] ."','". $data['ciudad'] ."','". self::hash($data['password']) ."','".$data['empresa']."','".$data['telefono']."','".$data['direccion']."',".$data['tipo'].",".$data['sector'].",".$data['ruc'].")");

        return true;
    }

    public static function all()
    {
        return self::query("SELECT *,(SELECT COUNT(id) FROM {cartera}.tb_carrito WHERE id_cliente={cartera}.{model}.id) as productos FROM {cartera}.{model}");
    }

    public static function sendConfirmationEmail()
    {
        self::queryOneTime("UPDATE {cartera}.{model} SET verificado=0,correo_verificador='" . self::random_string(50) . "' WHERE id=" . Session::get('sivoz_auth')->id);
        $result = self::query("SELECT * FROM {cartera}.{model} WHERE id=" . Session::get('sivoz_auth')->id, [], self::FETCH_ONE);
        Session::set('sivoz_auth', $result);
    }
    

    public static function confirmarCorreo($token)
    {
        $cliente = self::query("SELECT * FROM {cartera}.{model} WHERE id=" . Session::get('sivoz_auth')->id, [], self::FETCH_ONE);

        if($cliente){
            if($cliente->correo_verificador == $token){
                $sql = self::queryOneTime("UPDATE {cartera}.{model} SET verificado=1,correo_verificador='' WHERE id=" . Session::get('sivoz_auth')->id);
                $result = self::query("SELECT * FROM {cartera}.{model} WHERE id=" . Session::get('sivoz_auth')->id, [], self::FETCH_ONE);
                Session::set('sivoz_auth', $result);
            }
        }
    }

    public static function ventasUltimosMeses($m)
    {
        $firstMonht = date('m') - $m + 1;
        $data = [];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labels = [];
        $dataset = [];


        for($i = $firstMonht; $i <= date('m'); $i++){
            if($i < 0){
                $labels[] = $months[$i + 12];
                $data[] = ['mes' => $i+12, 'total' => 0, 'nombre' => $months[$i + 12]];
            }else if($i > 0){
                $labels[] = $months[$i - 1];
                $data[] = ['mes' => $i, 'total' => 0, 'nombre' => $months[$i - 1]];
            }
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

    public static function activos($m)
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

    public static function servicio()
    {   
        return true;
        $servicio = self::query("SELECT * FROM tb_suscripciones WHERE id_cliente=" . Session::get('sivoz_auth')->id);

        if($servicio){
            return $servicio;
        }else{
            return false;
        }
    }
}
