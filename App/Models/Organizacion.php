<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;

class Organizacion extends \Core\Model
{

    const TABLE = 'tb_organizacion';

    public static function create($user){
        
        self::queryOneTime("INSERT INTO {cartera}.{model}  ( `tipo_cliente`, `sector`, `empresa`, `numero`, `direccion`, `pais`, `ciudad`, `extension`) VALUES ( '1', '1', 'TEST NAT', '05121231213', 'QUITO', 'ECUADOR', 'QUITO', 'ftp.com')");

        return true;
    } 

    public static function all($cb){
        
        $organizaciones = self::query("SELECT * FROM {cartera}.{model} ");

        return $cb($organizaciones);
    }

    public static function findById($data, $cb){
        
        $organizaciones = self::query("SELECT * FROM {cartera}.{model} WHERE extension ='".$data['extension']."'");

        return $cb($organizaciones);
    }

}