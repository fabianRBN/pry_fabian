<?php 
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;



class Extensiones extends \Core\Model
{
    const TABLE = 'cat_ext_correo';

    public static function create($data,$cb){
  
        self::query("INSERT INTO  {general}.{model}  (extension) VALUES ( '".$data['extension']."')");
            $error = false;
  

        $mensaje = 'La extension '.$data['extension']." fue registrada";
    

        return $cb( array('error'=> $error , 'mensaje'=> $mensaje));

    }


    public static function all(){

        return self::query("SELECT * FROM {general}.{model} ");

    }

    public static function delete($data,$cb){
  
        self::query("DELETE FROM {general}.{model} WHERE id =  ".$data['extension']."");
            $error = false;
  

        $mensaje = 'La extension '.$data['extension']." fue registrada";
    

        return $cb( array('error'=> $error , 'mensaje'=> $mensaje));

    }
}

