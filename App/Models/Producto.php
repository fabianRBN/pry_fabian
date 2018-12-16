<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Config;
use \Core\Session;


class Producto extends \Core\Model
{
    const TABLE = 'cat_productos';

    public static function all()
    {
        return static::query("SELECT * FROM {cartera}.{model} WHERE activo=1 ORDER BY orden");
    }
    public static function masters()
    {
        $productos = static::query("SELECT p.id,p.nombre,p.precio,p.descripcion,p.fecha_creacion,c.nombre categoria,t.nombre tipo_pago,p.venta,p.proximamente,p.demo,p.activo,p.configurable,p.venta_precio_real FROM {cartera}.{model} as p INNER JOIN {cartera}.cat_categorias as c ON c.id=p.categoria INNER JOIN {cartera}.cat_tipo_pago as t ON t.id=p.tipo_pago ORDER BY p.orden" );

        return $productos;
    }

    public static function tienda()
    {
        return static::query("SELECT * FROM {cartera}.{model} WHERE estatus=1 ORDER BY CHAR_LENGTH(descripcion)");
    }

    public static function vdc()
    {

        return static::query("SELECT * FROM {cartera}.cat_productos WHERE estatus=1 and tipoWeb='VDC' ORDER BY orden");
    }

    public static function otros()
    {

        return static::query("SELECT * FROM {cartera}.cat_productos WHERE estatus=1 and tipoWeb='Otros' ORDER BY orden");
    }

    public static function maquinas()
    {

        return static::query("SELECT * FROM {cartera}.cat_productos WHERE estatus=1 and (tipoWeb='Maquina Virtual' or tipoWeb = 'Servidores Virtuales') ORDER BY orden");
    }

    public static function demos()
    {

        return static::query("SELECT * FROM {cartera}.cat_productos WHERE estatus=1 and demo=1 ORDER BY orden");
    }

    public static function proximamentes()
    {

        return static::query("SELECT * FROM {cartera}.cat_productos WHERE estatus=1 and proximamente=1 ORDER BY orden");
    }


    public static function website($tipo)
    {
        if($tipo == 1){
            $productos = static::query("SELECT * FROM {cartera}.{model} WHERE activo=1 and venta=1 and tipoWeb='VDC' ORDER BY orden");
        }else if($tipo == 2){
            $productos = static::query("SELECT * FROM {cartera}.{model} WHERE activo=1 and venta=1 and (tipoWeb='Maquina Virtual' or tipoWeb ='Servidores Virtuales') ORDER BY orden");
        }else if($tipo == 3){
            $productos = static::query("SELECT * FROM {cartera}.{model} WHERE activo=1 and venta=1 and tipoWeb='Otros' ORDER BY orden");
        }else if($tipo == 4){
            $productos = static::query("SELECT * FROM {cartera}.{model} WHERE activo=1 and demo=1 ORDER BY orden");
        }else{
            $productos = static::query("SELECT * FROM {cartera}.{model} WHERE activo=1 and proximamente=1 ORDER BY orden");
        }

        
        $all = [];
        foreach($productos as $producto){
            $producto->opciones = static::query("SELECT * FROM {cartera}.cat_opciones WHERE id_producto=" . $producto->id ." AND tipo != 2");
            $all[] = count($producto->opciones);
        }
        $max = max($all);
        $first = 0;
        $final = [];

        for($i = 0; $i < count($all); $i++){
            if($all[$i] == $max){
                $first = $i;
            }
        }

        for($i = 0; $i < count($productos); $i++){
            if($i == $first){
                $final[] = $productos[$i];
            }
        }

        for($i = 0; $i < count($productos); $i++){
            if($i !== $first){
                $final[] = $productos[$i];
            }
        }

        $productos = $final;

        $po = [];

        $inputsG = 0;
        foreach($productos as $producto){
            $inputs = 0;
            foreach($producto->opciones as $opcion){
                if($opcion->tipo == 1){
                    $opcion->display = $opcion->nombre;
                }
                if($opcion->tipo == 2){
                    $opcion->display = false;
                    $inputs = $inputs + 1;
                }
                if($opcion->tipo == 4){
                    $opcion->display = $opcion->nombre;
                }
                if($opcion->tipo == 5){
                    if($opcion->opciones !== ''){
                        $opcion->display = $opcion->nombre;
                    }
                }
            }
            if(count($producto->opciones) < count($productos[0]->opciones)){
                $m = count($productos[0]->opciones) - count($producto->opciones);
                $m = $m - $inputsG;
                for($i = 0; $i < $m; $i++){
                    $producto->opciones[] = (object) [
                        'tipo' => 6,
                        'display' => 'no'
                    ];
                }
            }else{
                $inputsG = $inputs;
            }
            if(file_exists($producto->imagenPath)){
                try {
                    $im = file_get_contents($producto->imagenPath);
                   
                    $im2 = 'data:image/png;base64,'. base64_encode($im);
                    
                } catch (Exception $e) {
                    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                }
                $producto->imagen= $im2;
                
            }
        }

        return $productos;
    }


    public static function cart()
    {
        if(!isset($_SESSION['cart'])){
            return [];
        }
        else{
            if(count((array) Session::get('cart')) > 0){
                $cart = implode(',', (array) Session::get('cart'));
                $productos = self::query("SELECT * FROM {cartera}.{model} WHERE id in($cart)");
                foreach($productos as $producto){
                    $producto->opciones = self::query("SELECT * FROM cat_opciones WHERE id_producto =". $producto->id);
                }
                return $productos;
            }else{
                return [];
            }
           
        }
    }

    public static function withCategories()
    {
        $productos = static::query("SELECT * FROM {cartera}.{model}");

        foreach($productos as $producto){
            $producto->opciones = static::query("SELECT * FROM {cartera}.cat_opciones WHERE id_producto=" . $producto->id);
        }

        return $productos;
    }

    public static function findById($id)
    {
        $producto = self::query("SELECT * FROM {cartera}.{model} WHERE id=:id", array('id'=>$id), self::FETCH_ONE);
        $producto->opciones = static::query("SELECT * FROM {cartera}.cat_opciones WHERE id_producto=" . $producto->id);
        foreach($producto->opciones as $opcion){
            $carrito = static::query("SELECT * FROM {cartera}.tb_carrito_opciones  WHERE id_opcion=" . $opcion->id);
            if($carrito){
                $opcion->exist = 'true';
            }else{
                $opcion->exist = 'false';
            }
        }
        
        return $producto;

    }

    public static function edit($data, $cb)
    {
        echo 'Se inicia la actualizacion';
        echo strval($data->imagenPath);
        self::queryOneTime("UPDATE {cartera}.cat_productos SET categoria='". $data->categoria ."',nombre='". $data->nombre ."',precio=". str_replace('$','',str_replace(',','',$data->precio)) .",descripcion='". $data->descripcion ."',tipo_pago=". $data->tipo_pago .",venta=". $data->venta .",proximamente=". $data->proximamente .",demo=". $data->demo .",activo=". $data->activo .",configurable=". $data->configurable. ",mostrar_label=". $data->mostrar_label .",venta_precio_real=". $data->venta_precio_real.",imagenPath='".$data->imagenPath ."',tipoWeb ='".$data->tipo_Web."',orden =".$data->orden." WHERE id=" . $data->id);
        echo 'Se actualizo Correctamente';
		//self::queryOneTime("DELETE FROM {cartera}.cat_opciones WHERE id_producto=" . $data->id);


        foreach($data->opcionesrm as $opcionrm){
            self::queryOneTime("DELETE FROM {cartera}.cat_opciones WHERE id =" . $opcionrm->id);

        }

       foreach($data->opciones as $opcion){
            if (array_key_exists('id', $opcion)){
                self::queryOneTime("UPDATE {cartera}.cat_opciones SET  id_producto= ". $data->id .",nombre= '". $opcion->nombre ."',opciones= '". $opcion->opciones ."',precio= ". str_replace('$','',str_replace(',','',$opcion->precio)) .",estatus= 1,tipo='". $opcion->tipo ."',max = '". $opcion->max ."',min='". $opcion->min ."',valor= '". $opcion->valor ."',opciones_precio = '". $opcion->opciones_precio."' WHERE id = ".$opcion->id);

            }else{
                self::queryOneTime("INSERT INTO {cartera}.cat_opciones (id_producto,nombre,opciones,precio,estatus,tipo,max,min,valor,opciones_precio) VALUES (". $data->id .",'".$opcion->nombre ."','". $opcion->opciones ."',". str_replace('$','',str_replace(',','',$opcion->precio)) .",1,'". $opcion->tipo ."','". $opcion->max ."','". $opcion->min ."','". $opcion->valor ."','". $opcion->opciones_precio."')");

            }
        } 

        $cb(true);
    }

    public static function subir($data, $cb)
    {

        echo "Se inicia la subida";
        $imageData = $data->imagen;
		echo "Se realiza la subida";
		echo $data->imagenPath;
		if($data->imagenPath != ''){
			list($type, $imageData) = explode(';', $imageData);
			list(, $imageData)      = explode(',', $imageData);
			$imageData = base64_decode($imageData);
			if(file_exists($data->imagenPath)){
				unlink($data->imagenPath);
			}

			file_put_contents($data->imagenPath, $imageData);
		}
        
		
		echo "Se finaliza la subida";
		$cb(true);
    }

	public static function is_obj_empty($obj){
	   echo "Se inicia a verificar el objeto";
	   if( is_null($obj) ){
		  return true;
	   }
	   echo "El objeto no es nulo";
	   
	   foreach( $obj as $key => $val ){
		  return false;
	   }
	   echo "El objeto no tiene elementos";
	   return true;
	}
	
    public static function graph()
    {
        $dataset = [];
        $temp = [];
        $labels = [];
        $p = self::query("SELECT nombre FROM {cartera}.{model}");
        $d = self::query("SELECT COUNT(c.id) as total,p.nombre as producto FROM {cartera}.tb_carrito as c INNER JOIN {cartera}.{model} as p ON p.id=c.id_producto GROUP BY p.nombre");
        for($i = 0; $i < count($p); $i++){
            $labels[] = $p[$i]->nombre;
            $dataset[] = 0;
        }

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($labels); $j++){
                if($labels[$j] == $d[$i]->producto){
                    $dataset[$j] = (int) $d[$i]->total;
                }
            }
        }

        return ['dataset' => $dataset, 'labels' => $labels];
    }

    public static function create($data, $cb)
    {
        self::queryOneTime("INSERT INTO {cartera}.{model} (nombre,precio,descripcion,tipo_pago,venta,proximamente,demo,activo,configurable,venta_precio_real,imagenPath,orden, tipoWeb,mostrar_label) VALUES ('". $data->nombre ."',". str_replace('$','',str_replace(',','',$data->precio)) .",'". $data->descripcion ."',". $data->tipo_pago .",". $data->venta .",". $data->proximamente .",". $data->demo .",". $data->activo .",". $data->configurable .",". $data->venta_precio_real .",'". $data->imagenPath ."',". $data->orden.",'". $data->tipo_Web."',".$data->mostrar_label. ")");
		
        $producto = self::query("SELECT * FROM {cartera}.{model} WHERE nombre='". $data->nombre ."' AND precio=" . str_replace('$','',str_replace(',','',$data->precio)), [], self::FETCH_ONE);

        Estatus::cloneFlow('carrito',$producto->id);

        foreach($data->opciones as $opcion){
            self::queryOneTime("INSERT INTO {cartera}.cat_opciones (id_producto,nombre,opciones,precio,estatus,tipo,max,min,valor,opciones_precio) VALUES (". $producto->id .",'".htmlspecialchars($opcion->nombre) ."','". $opcion->opciones ."',". str_replace('$','',str_replace(',','',$opcion->precio)) .",1,'". $opcion->tipo ."','". $opcion->max ."','". $opcion->min ."','". $opcion->valor ."',' ".$opcion->opciones_precio."')");


        }

        $cb(true);
    }
}
