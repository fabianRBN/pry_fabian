<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use \App\Config;


class Uploadfiles extends \Core\Model
{

    const TABLE = 'cat_files';


    public static function upload($file){

    
      if(!empty($file))
      {
          if(is_uploaded_file($file['uploadFile']['tmp_name'])){
              sleep(1);
              $source_path = $file['uploadFile']['tmp_name'];

              $nombre = $file['uploadFile']['name'];
              $nombre = str_replace(' ','_',$nombre);
              $nombre = str_replace('/','_',$nombre);
             
              $target_path = Config::Folder. "/Documents/" . $nombre;

              if($file['uploadFile']['type'] == "application/pdf"){

                

                if(move_uploaded_file($source_path, $target_path)){
                 
                  
                  self::query("INSERT INTO {general}.{model} ( id_producto, id_estatus, ruta, nombre) VALUES (1,2,'c:/','".$nombre."')");
                }
              }else{
                  echo "<script>uploadsuccess('fail')</script>";
              }
          }else{
              echo "no existe";
          }    
      }

    }


}