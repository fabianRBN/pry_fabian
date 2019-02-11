<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use \App\Config;


class Uploadfiles extends \Core\Model
{

    const TABLE = 'cat_files';


    public static function upload($file,$data){

    
      if(!empty($file))
      {
          if(is_uploaded_file($file['uploadFile']['tmp_name'])){
              sleep(1);
              $source_path = $file['uploadFile']['tmp_name'];

              $nombre = $data['textalias'];
              $nombre = str_replace(' ','_',$nombre);
              $nombre = str_replace('/','_',$nombre);
                $nombre =  $nombre .".pdf";
             
              $target_path = Config::Folder. "/Documents/". $nombre;

              if($file['uploadFile']['type'] == "application/pdf"){

                $archivos = self::query("SELECT * FROM {general}.{model} WHERE id_carrito =".$data['txtidcarrito']." AND id_estatus=".$data['txtestatus']);
                
                if($archivos){
                    unlink($archivos[0]->ruta);
                }

                if(move_uploaded_file($source_path, $target_path)){
                 
                  
                    if($archivos){
                        self::query("UPDATE {general}.{model} SET ruta='".$target_path."',nombre='".$nombre."',alias='".$data['textalias']."',id_usuario=".$data['txtidUsuario']." WHERE id_carrito=".$data['txtidcarrito']." AND id_estatus=".$data['txtestatus']);
                        echo "<script>uploadsuccess(". json_encode(  array('error'=>false, 'texto'=>'El archivo actualizado' ) ) .")</script>";

                    }else{
                        self::query("INSERT INTO {general}.{model} ( id_carrito, id_estatus, ruta, nombre, alias,id_usuario) VALUES (".$data['txtidcarrito'].",".$data['txtestatus'].",'".$target_path."','".$nombre."','".$data['textalias']."',".$data['txtidUsuario'].")");
                        echo "<script>uploadsuccess(". json_encode(  array('error'=>false, 'texto'=>'El archivo guardado' ) ) .")</script>";
                    }


                }
              }else{
                echo "<script>uploadsuccess(". json_encode(  array('error'=>false, 'texto'=>'Error al carga el archivo' ) ).")</script>";
            }
          }else{
            echo "<script>uploadsuccess(". json_encode(  array('error'=>false, 'texto'=>'Error al carga el archivo' ) ).")</script>";
        }    
      }

    }


    public static function archivosporcarrito($idcarrito){

        $archivos = self::query("SELECT * FROM {general}.{model} WHERE id_carrito =".$idcarrito);

        foreach($archivos as $archivo){
            $usuario =  self::query("SELECT * FROM {general}.tb_usuarios WHERE id =". $archivo->id_usuario )[0];
            $estatus = self::query("SELECT * FROM {general}.cat_estatus WHERE tipo = 'carrito' AND codigo= ".  $archivo->id_estatus)[0];
            $archivo->usuario =  $usuario->nombre .' '. $usuario->apellidos;
            $archivo->estatus = $estatus->nombre;
        }

        return $archivos;

    }



}