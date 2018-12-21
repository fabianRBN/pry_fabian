<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace Core;

class Input
{
    public static function has($value)
    {
        if(isset($_GET[$value]) || isset($_POST[$value])){
            return true;
        }

        return false;
    }

    public static function hasGet()
    {
        if(count($_GET) > 0){
            
            return true;
        }

        return false;
    }
    public static function hasPost()
    {
        if(count($_POST) > 0){
            
            return true;
        }

        return false;
    }

    public static function all()
    {
        if(count($_GET) > 0){
            
            return (object) $_GET;
        }
        if(count($_POST) > 0){

            return (object) $_POST;
        }

        return false;
    }


    public static function get($value)
    {
        if(isset($_GET[$value])){
            return $_GET[$value];
        }
        if(isset($_POST[$value])){
            return $_POST[$value];
        }

        return false;
    }
}
