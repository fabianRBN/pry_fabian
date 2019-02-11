<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace Core;

use Exception;
use PDO;
use App\Config;

/**
 * Base model
 *
 * PHP version 7.0
 */
abstract class Model
{
    const FETCH_ONE = 'one';
    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_PREFIX . 'car' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    public static function query($sql, $args = [], $fetch = 'all')
    {
        $db = static::getDB();
        $sql = str_replace('{model}', static::TABLE, $sql);
        $sql = str_replace('{prefix}', Config::DB_PREFIX, $sql);
        $sql = str_replace('{dbname}', Config::DB_PREFIX . Config::DB_NAME . '.', $sql);
        $sql = str_replace('{cartera}', Config::DB_PREFIX . 'car' . Config::DB_NAME, $sql);
        preg_match_all('#\{(.*?)\}#', $sql, $match);

        foreach($match[1] as $m){
            $sql = str_replace('{'. $m .'}', Config::DB_PREFIX . $m, $sql);
        }

        
        Binnacle::create([
            '-- NUEVA CONSULTA -- ' . date('Y-m-d h:i:s'),
            '-- SQL -- ' . $sql,
            '-- CONTROLADOR -- ' . Binnacle::getRoute('controller'),
            '-- FUNCION -- ' . Binnacle::getRoute('action'),
            '-- RUTA -- ' . Binnacle::getRoute('route')
        ], false);
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($args);

            Binnacle::create([
                '-- PDO ERROR -- FALSE'
            ]);

            if($fetch == 'one'){
                return $stmt->fetch(PDO::FETCH_OBJ);
            }else{
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(Exception $e) {
        }
        
    }

    public static function querySegura($sql, $args = [], $fetch = 'all',$data)
    {
        $db = static::getDB();
        $sql = str_replace('{model}', static::TABLE, $sql);
        $sql = str_replace('{prefix}', Config::DB_PREFIX, $sql);
        $sql = str_replace('{dbname}', Config::DB_PREFIX . Config::DB_NAME . '.', $sql);
        $sql = str_replace('{cartera}', Config::DB_PREFIX . 'car' . Config::DB_NAME, $sql);
        preg_match_all('#\{(.*?)\}#', $sql, $match);

        foreach($match[1] as $m){
            $sql = str_replace('{'. $m .'}', Config::DB_PREFIX . $m, $sql);
        }

        
        Binnacle::create([
            '-- NUEVA CONSULTA -- ' . date('Y-m-d h:i:s'),
            '-- SQL -- ' . $sql,
            '-- CONTROLADOR -- ' . Binnacle::getRoute('controller'),
            '-- FUNCION -- ' . Binnacle::getRoute('action'),
            '-- RUTA -- ' . Binnacle::getRoute('route')
        ], false);
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($args);
            $stmt->bindParam(":email", $data, PDO::PARAM_STR);
            Binnacle::create([
                '-- PDO ERROR -- FALSE'
            ]);

            if($fetch == 'one'){
                return $stmt->fetch(PDO::FETCH_OBJ);
            }else{
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(Exception $e) {
        }
        
    }
    

    public static function token($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }
    

    public static function queryOneTime($sql, $args = [], $fetch = 'all')
    {
        $db = static::getDB();
        $sql = str_replace('{model}', static::TABLE, $sql);
        $sql = str_replace('{prefix}', Config::DB_PREFIX, $sql);
        $sql = str_replace('{dbname}', Config::DB_PREFIX . Config::DB_NAME, $sql);
        $sql = str_replace('{cartera}', Config::DB_PREFIX . 'car' . Config::DB_NAME, $sql);
        preg_match_all('#\{(.*?)\}#', $sql, $match);

        foreach($match[1] as $m){
            $sql = str_replace('{'. $m .'}', Config::DB_PREFIX . $m, $sql);
        }

        
        Binnacle::create([
            '-- NUEVA CONSULTA -- ' . date('Y-m-d h:i:s'),
            '-- SQL -- ' . $sql,
            '-- CONTROLADOR -- ' . Binnacle::getRoute('controller'),
            '-- FUNCION -- ' . Binnacle::getRoute('action'),
            '-- RUTA -- ' . Binnacle::getRoute('route')
        ], false);
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($args);

            Binnacle::create([
                '-- PDO ERROR -- FALSE'
            ]);
        }
        catch(Exception $e) {
        }
    }

    public static function validate($array, $data)
    {
        $pass = false;
        foreach($array as $ar){
            Session::set($ar . '_value_input',$data[$ar]);
            if(!isset($data[$ar])){
                Session::set($ar . '_error','Este campo es requerido');
                $pass = false;
            }else{
                
                if($data[$ar] == ''){
                    Session::set($ar . '_error','Este campo es requerido');
                    $pass = false;
                }else{
                    $pass = true;
                }
            }
        }

        return $pass;
    }
    public static function clearSession($array)
    {
        $pass = true;
        foreach($array as $ar){
            Session::remove($ar . '_value_input');
        }

        return $pass;
    }

    public static function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }

    public static function hash($string)
    {
        $password = hash('sha256', \App\Config::SHA_TOKEN.$string);
  
        return $password;
    }

    public static function checkHash($hashed,$normal)
    {
        if($hashed == hash('sha256', \App\Config::SHA_TOKEN.$normal)){
            return true;
        }else{
            return false;
        }
    }
}
