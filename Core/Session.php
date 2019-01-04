<?php

namespace Core;

/**
 * Error and exception handler
 *
 * PHP version 7.0
 */
class Session
{


    public static function get($value = null)
    {
        if($value == null){
            return (object) $_SESSION;
        }else{
            if(!isset($_SESSION[$value])){
                return false;
            }else{
                return (object) $_SESSION[$value];
            }
        }
    }

    public static function has($value)
    {
        if(!isset($_SESSION[$value])){

            return false;
        }else{

            return true;
        }
    }




    public static function flash($name)
    {
        if(isset($_SESSION[$name])){
            $session = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $session;
        }

        return '';
    }

    public static function canSee($permisos)
    {
        if($permisos[0] == 'all'){
            return true;
        }else{
            foreach($permisos as $permiso){
                if(self::get('sivoz_auth') !== false){
                    if(self::get('sivoz_auth')->permiso == $permiso){
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function set($name,$value)
    {
        $_SESSION[$name] = $value;


    }

    public static function createToken(){
        return $_SESSION['tokenCSRF'] = strval(bin2hex(openssl_random_pseudo_bytes(32)));
    }

    public static function verificarToken($token){

        if(Session::get('sivoz_auth')){
            if (isset($_SESSION['tokenCSRF'])){ 
                if($_SESSION['tokenCSRF'] === $token){
                    unset($_SESSION['tokenCSRF']);
                    return true;
                }else{
                    return false;
                }
            }else{
                Router::redirect('/administracion/productos');

            } 

            
        }else{
            View::render('error.500');
        }
    }

    public static function verificarTokenForgot($token){

       
            if (isset($_SESSION['tokenCSRF'])){ 
                if($_SESSION['tokenCSRF'] === $token){
                    unset($_SESSION['tokenCSRF']);
                    return true;
                }else{
                    return false;
                }
            }else{
                Router::redirect('/');

            } 

            
    }
    
    public static function remove($name)
    {
        if(isset($_SESSION[$name])){
            $session = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $session;
        }

        return '';
    }
}
