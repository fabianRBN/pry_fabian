<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace Core;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Binnacle
{
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function create($string, $end = true)
    {
        $file = dirname(__DIR__) . "/logs/bitacora" . date('Ymd') . ".txt";
        if($end == false){
            file_put_contents($file, '-- USER IP -- ' . self::getUserIP() . "\n", FILE_APPEND);
            file_put_contents($file, '-- BROWSER -- ' . $_SERVER['HTTP_USER_AGENT'] . "\n", FILE_APPEND);
            file_put_contents($file, '-- METHOD -- ' . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
            if(Session::get('sivoz_auth') !== false){
                file_put_contents($file, '-- ID-USUARIO -- ' . Session::get('sivoz_auth')->id . "\n", FILE_APPEND);
                file_put_contents($file, '-- NOMBRE-USUARIO -- ' . Session::get('sivoz_auth')->nombre . ' ' . Session::get('sivoz_auth')->apellidos . "\n", FILE_APPEND);
                file_put_contents($file, '-- PERMISO-USUARIO -- ' . Session::get('sivoz_auth')->permiso . "\n", FILE_APPEND);
            }else{
                file_put_contents($file, '-- USUARIO -- EXTERNO' . "\n", FILE_APPEND);
            }
        }
        foreach($string as $txt){
            file_put_contents($file, $txt . "\n", FILE_APPEND);
        }
        if($end == true){
            file_put_contents($file, '----------------------------------' . "\n", FILE_APPEND);
        }

    }

    public static function show($date)
    {
        $file = dirname(__DIR__) . "/logs/bitacora" . $date . ".txt";
        echo '<pre>';
        $str = nl2br(file_get_contents($file));
        echo $str;
        echo '</pre>';
    }

    public static function addRoute($string)
    {
        // Implementacion de cookie remplazando router.log
        $_SESSION['rootlog']=$string;


        //$file = dirname(__DIR__) . "/logs/route.log";
       // file_put_contents($file, $string);
    }

    public static function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }


    public static function getRoute($attr)
    {
    //$file = dirname(__DIR__) . "/logs/route.log";
      
    // $array = json_encode(file_get_contents($file));
        
    // $array = array("controller"=>"App\\Controllers\\Mantenimiento","action"=>"auth","route"=>"App\/Controllers\/Mantenimiento.php");
        
    
        if(!isset( $_SESSION['rootlog'])){

            $array = array("controller"=>"App\\Controllers\\Website","action"=>"home","route"=>"App\/Controllers\/Website.php");

        }else{
            $array = (array) json_decode( $_SESSION['rootlog'] ); 

        }


    return $array[$attr];
    }

}


