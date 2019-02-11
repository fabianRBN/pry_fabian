<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;

class Organizacion extends \Core\Model
{

    const TABLE = 'tb_organizacion';

    public static function create($data){
        
        self::queryOneTime("INSERT INTO {cartera}.{model}  ( `tipo_cliente`, `sector`, `empresa`, `numero`, `direccion`, `pais`, `ciudad`, `extension`) 
            VALUES ( ".$data['tipo'].", ".$data['sector'].", '".$data['empresa']."', '".$data['telefono']."', '".$data['direccion']."', '".$data['pais']."', '".$data['ciudad']."', '". explode('@',$data['correo'])[1]."')");

 
    } 

    public static function all($cb){
        
        $organizaciones = self::query("SELECT * FROM {cartera}.{model} ");

        return $cb($organizaciones);
    }

    public static function findById($data, $cb){
        
        $organizaciones = self::query("SELECT * FROM {cartera}.{model} WHERE extension = :extension ", array('extension'=>$data['extension']),self::FETCH_ONE);

        return $cb($organizaciones);
    }

}