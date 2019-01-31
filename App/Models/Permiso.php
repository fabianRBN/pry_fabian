<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Permiso extends \Core\Model
{
    const TABLE = 'cat_permisos';

    public static function all()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }
    public static function getAll()
    {
        return static::query("SELECT * FROM {general}.{model}");
    }

    public static function getAlls()
    {
        return static::query("SELECT p.nombre,p.id,(SELECT COUNT(id) FROM {general}.tb_usuarios as u WHERE u.permiso = p.id) as usuarios,a.nombre as area FROM {general}.{model} as p INNER JOIN {general}.cat_areas as a ON a.id=p.area");
    }

    public static function findBy($id)
    {
        return self::query("SELECT * FROM {general}.{model} WHERE id='$id'", [], self::FETCH_ONE);
    }

    public static function edit($data, $cb)
    {
        self::queryOneTime("UPDATE {general}.{model} SET nombre='". strtoupper($data['nombre']) ."',area=". $data['area'] ." WHERE id=" . $data['id']);

        $cb(true);
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {general}.{model} (nombre,area) VALUES ('". strtoupper($data['nombre']) ."',". $data['area'] .")");

        $cb(true);
    }

    public static function createAreaNotificada($data, $cb)
    {
        $result =  self::query("SELECT * FROM {general}.cat_areas_notificadas WHERE id_permiso =".htmlentities(strtoupper($data['id_permiso']))." AND id_estatus =". htmlentities(strtoupper($data['id_estatus'])));
        $error = true;
        
        if(count($result) == 0){
            self::queryOneTime("INSERT INTO {general}.cat_areas_notificadas  ( id_permiso, id_estatus) VALUES (".htmlentities(strtoupper($data['id_permiso'])) ." , ".htmlentities(strtoupper($data['id_estatus'])). ")");
            $error = false;
            $mensaje = 'Registro completo';
        }else{
            $error = true;
            $mensaje = 'Ya existe regla registrada';
        }

        $cb( array('error'=> $error , 'mensaje'=> $mensaje));

    }


    public static function permisoAccion($permiso){
        $result = self::query("SELECT * FROM {general}.cat_areas_notificadas WHERE id_permiso =".htmlentities(strtoupper($permiso)));
        if(count($result) == 0){
            return false;
        }else{
            return true;
        }
    }

    public static function notificadas(){

        return self::query("SELECT id, id_permiso, id_estatus, (SELECT nombre FROM  {general}.cat_permisos WHERE id = id_permiso ) as permiso , ( SELECT nombre FROM  {general}.cat_estatus WHERE id = id_estatus  ) as estatus  FROM {general}.cat_areas_notificadas   ");
    }


    public static function deleteAreaNotificada($data, $cb){
        
        self::query("DELETE FROM {general}.cat_areas_notificadas WHERE id = ".$data['id']);

        return $cb(array('error'=> false, 'mensaje'=> 'Eliminacion correcta'));

    }

    public static function permisosUsers(){
        return self::query("SELECT id_estatus , (SELECT  codigo FROM  {general}.cat_estatus WHERE id = id_estatus ) as codigo  FROM {general}.cat_areas_notificadas WHERE id_permiso = ".$_SESSION['sivoz_auth']->permiso);
    }
    
}
