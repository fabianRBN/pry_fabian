<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Models;

use PDO;
use \App\Models\Firma;
use \App\Models\Alert;
use \App\Models\Estatus;
use \App\Config;
use \Core\Session;
use \Core\Binnacle;


class Carrito extends \Core\Model
{
    const TABLE = 'tb_carrito';

    public static function add($carrito, $cb)
    {
		echo "Se agrega el carrito";
        $last = self::query("SELECT * FROM {cartera}.{model} ORDER BY fecha_registro DESC LIMIT 1 ",[],self::FETCH_ONE);

        if(Session::has('cart')){
            $cert = (array) Session::get('cart');
            for($i = 0; $i < count($cert); $i++){
                if($cert[$i] == $carrito['id_producto']){
                    unset($cert[$i]);
                }
            }
            Session::set('cart', $cert);
        }

        if($last){
            $ticket = $last->ticket + 1;
        }else{
            $ticket = 1;
        }

        

     
        // static::queryOneTime("INSERT INTO {cartera}.{model} (id_cliente,id_producto,total,subtotal,fecha_pago,estatus,ticket) VALUES (".  $carrito['id_cliente'] .",". $carrito['id_producto'] .",". $carrito['total'] .",". $carrito['subtotal'] .",'". $carrito['fecha_pago'] ."',". $carrito['estatus'] .",". $ticket .")");

        // $last = self::query("SELECT * FROM {cartera}.{model} ORDER BY fecha_registro DESC LIMIT 1 ",[],self::FETCH_ONE);
        // $c = self::query("SELECT * FROM {cartera}.{model} WHERE ticket=" . $last->ticket,[],self::FETCH_ONE);

        // foreach($carrito['opciones'] as $opcion){
        //     static::queryOneTime("INSERT INTO {cartera}.tb_carrito_opciones (id_carrito,id_opcion,value,precio) VALUES (". $c->id .",". $opcion['opcion'] .",'". $opcion['value'] ."',". $opcion['precio'] .")");
        // }

        // XSS atack 
        static::queryOneTime("INSERT INTO {cartera}.{model} (id_cliente,id_producto,total,subtotal,fecha_pago,estatus,ticket) VALUES (". htmlspecialchars($carrito['id_cliente'], ENT_QUOTES, "UTF-8")  .",". htmlspecialchars($carrito['id_producto'], ENT_QUOTES, "UTF-8")  .",". htmlspecialchars($carrito['total'], ENT_QUOTES, "UTF-8")  .",".htmlspecialchars($carrito['subtotal'], ENT_QUOTES, "UTF-8")  .",'". htmlspecialchars($carrito['fecha_pago'], ENT_QUOTES, "UTF-8")  ."',".htmlspecialchars($carrito['estatus'], ENT_QUOTES, "UTF-8")  .",". htmlspecialchars($ticket, ENT_QUOTES, "UTF-8")  .")");

        $last = self::query("SELECT * FROM {cartera}.{model} ORDER BY fecha_registro DESC LIMIT 1 ",[],self::FETCH_ONE);
        $c = self::query("SELECT * FROM {cartera}.{model} WHERE ticket=" . $last->ticket,[],self::FETCH_ONE);

        foreach($carrito['opciones'] as $opcion){


            static::queryOneTime("INSERT INTO {cartera}.tb_carrito_opciones (id_carrito,id_opcion,value,precio) VALUES (". $c->id .",".htmlspecialchars($opcion['opcion'], ENT_QUOTES, "UTF-8")   .",'". htmlspecialchars($opcion['value'], ENT_QUOTES, "UTF-8") ."',".htmlspecialchars($opcion['precio'], ENT_QUOTES, "UTF-8")   .")");
        }

        Notificacion::send('operacion/carrito?id=' . $last->id,$carrito['estatus'],'carrito',$last->id,'carrito');
        
        $cb(true);
    }


    public static function updatecarrito($carrito, $cb)
    {


        // XSS atack 
        static::queryOneTime("UPDATE  {cartera}.{model} SET total = ".htmlspecialchars($carrito['total'], ENT_QUOTES, "UTF-8")." ,subtotal =". htmlspecialchars($carrito['subtotal'], ENT_QUOTES, "UTF-8"). " WHERE id = ". htmlspecialchars($carrito['id_carrito'], ENT_QUOTES, "UTF-8") );

         foreach($carrito['opciones'] as $opcion){

            static::queryOneTime("UPDATE {cartera}.tb_carrito_opciones SET value = :value , precio = :precio WHERE id_carrito = :idcarrito AND  id_opcion = :id",
            array(':value'=> $opcion['value'], ':precio'=> $opcion['precio'], ':idcarrito'=> $carrito['id_carrito'], ':id'=>  $opcion['opcion']  ),"all");
         }

        //Notificacion::send('operacion/carrito?id=' . $last->id,$carrito['estatus'],'carrito',$last->id,'carrito');
        //             static::queryOneTime("UPDATE {cartera}.tb_carrito_opciones SET value = '".$opcion['value']."' , precio = ".$opcion['precio']." WHERE id_carrito = ".$carrito['id_carrito']." AND  id_opcion = ". $opcion['opcion']);

        
        $cb(true);
    }

    public static function comparativaSG($m)
    {
        $firstMonht = date('m') - $m + 1;
        $data = [];
        $data2 = [];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labels = [];
        $dataset = [];

        $labels2 = [];
        $dataset2 = [];


        for($i = $firstMonht; $i <= date('m'); $i++){
            if($i < 0){
                $labels[] = $months[$i + 12];
                $data[] = ['mes' => $i+12, 'total' => 0, 'nombre' => $months[$i + 12]];
            }else if($i > 0){
                $labels[] = $months[$i - 1];
                $data[] = ['mes' => $i, 'total' => 0, 'nombre' => $months[$i - 1]];
            }

     
        }

        $date = date("Y-m-d", strtotime("-$m months"));
        $now = date('Y-m-d', strtotime("+1 days"));

        $d = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro) AND estatus=10");

        $ds = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro) AND estatus=2");

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data); $j++){
                if($d[$i]->mes == $data[$j]['mes']){
                    $data[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        
        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data2); $j++){
                if($d[$i]->mes == $data2[$j]['mes']){
                    $data2[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        for($i = 0; $i < count($data); $i++){
            $dataset[] = $data[$i]['total'];
        }

        for($i = 0; $i < count($data2); $i++){
            $dataset2[] = $data2[$i]['total'];
        }

        return ['dataset' => [$dataset,$dataset2], 'labels' => $labels];
    }

    public static function comparativaSV($m)
    {
        $firstMonht = date('m') - $m + 1;
        $data = [];
        $data2 = [];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labels = [];
        $dataset = [];

        $labels2 = [];
        $dataset2 = [];


        for($i = $firstMonht; $i <= date('m'); $i++){
            
            if($i < 0){
                $labels[] = $months[$i + 12];
                $data[] = ['mes' => $i+12, 'total' => 0, 'nombre' => $months[$i + 12]];
            }else if($i > 0){
                $labels[] = $months[$i - 1];
                $data[] = ['mes' => $i, 'total' => 0, 'nombre' => $months[$i - 1]];
            }
        }

        $date = date("Y-m-d", strtotime("-$m months"));
        $now = date('Y-m-d', strtotime("+1 days"));

        $d = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro) AND estatus=10");

        $ds = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro) AND estatus=2");

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data); $j++){
                if($d[$i]->mes == $data[$j]['mes']){
                    $data[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        
        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data2); $j++){
                if($d[$i]->mes == $data2[$j]['mes']){
                    $data2[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        for($i = 0; $i < count($data); $i++){
            $dataset[] = $data[$i]['total'];
        }

        for($i = 0; $i < count($data2); $i++){
            $dataset2[] = $data2[$i]['total'];
        }

        return ['dataset' => [$dataset,$dataset2], 'labels' => $labels];
    }

    public static function retiros($m)
    {
        $firstMonht = date('m') - $m + 1;
        $data = [];
        $data2 = [];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labels = [];
        $dataset = [];

        $labels2 = [];
        $dataset2 = [];


        for($i = $firstMonht; $i <= date('m'); $i++){
            
            if($i < 0){
                $labels[] = $months[$i + 12];
                $data[] = ['mes' => $i+12, 'total' => 0, 'nombre' => $months[$i + 12]];
            }else if($i > 0){
                $labels[] = $months[$i - 1];
                $data[] = ['mes' => $i, 'total' => 0, 'nombre' => $months[$i - 1]];
            }
        }

        $date = date("Y-m-d", strtotime("-$m months"));
        $now = date('Y-m-d', strtotime("+1 days"));

        $d = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro) AND estatus=10");

        $ds = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro) AND estatus=2");

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data); $j++){
                if($d[$i]->mes == $data[$j]['mes']){
                    $data[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        
        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data2); $j++){
                if($d[$i]->mes == $data2[$j]['mes']){
                    $data2[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        for($i = 0; $i < count($data); $i++){
            $dataset[] = $data[$i]['total'];
        }

        for($i = 0; $i < count($data2); $i++){
            $dataset2[] = $data2[$i]['total'];
        }

        return ['dataset' => [$dataset,$dataset2], 'labels' => $labels];
    }

    public static function ventasUltimosMeses($m)
    {
        $firstMonht = date('m') - $m + 1;
        $data = [];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labels = [];
        $dataset = [];


        for($i = $firstMonht; $i <= date('m'); $i++){
            if($i < 0){
                $labels[] = $months[$i + 12];
                $data[] = ['mes' => $i+12, 'total' => 0, 'nombre' => $months[$i + 12]];
            }else if($i > 0){
                $labels[] = $months[$i - 1];
                $data[] = ['mes' => $i, 'total' => 0, 'nombre' => $months[$i - 1]];
            }
        }

        $date = date("Y-m-d", strtotime("-$m months"));
        $now = date('Y-m-d', strtotime("+1 days"));

        $d = self::query("SELECT COUNT(t.id) as total,MONTH(t.fecha_registro) as mes FROM {cartera}.{model} as t WHERE t.fecha_registro BETWEEN '$date' AND '$now' GROUP BY MONTH(t.fecha_registro)");

        for($i = 0; $i < count($d); $i++){
            for($j = 0; $j < count($data); $j++){
                if($d[$i]->mes == $data[$j]['mes']){
                    $data[$j]['total'] = (int) $d[$i]->total;
                }
            }
        }

        for($i = 0; $i < count($data); $i++){
            $dataset[] = $data[$i]['total'];
        }

        return ['dataset' => $dataset, 'labels' => $labels];
    }

    public static function findByID($id)
    {

        $carrito = self::query("SELECT * FROM {cartera}.{model} WHERE id = :id",array('id' => $id),self::FETCH_ONE);
        if(Session::get('sivoz_auth')->permiso == 7){
        }else{
			echo 'no autorizado';
			echo $carrito->estatus;
            if($carrito->estatus == 0){
                $carrito->estatus = 13; // se define el estado de recibido con el codigo 13 id 11
                self::queryOneTime("UPDATE {cartera}.{model} SET estatus=13 WHERE id=$id");
                Notificacion::send('administracion/carrito?id=' . $carrito->id,13,'carrito',$carrito->id,'carrito',$carrito->id_cliente);
            }
        }
	
        $carrito->estatus_data = self::query("SELECT * FROM {general}.cat_estatus WHERE tipo = 'carrito' AND codigo = " . $carrito->estatus, [], self::FETCH_ONE);
		$es = Estatus::processFind($carrito->id_producto,$carrito->estatus_data->id, 'carrito');
		
        $carrito->consecutivos = self::query("SELECT * FROM {general}.cat_estatus WHERE tipo = 'carrito' AND id IN(".$es.")");

        foreach($carrito->consecutivos as $consecutivo){
            foreach( (self::query("SELECT email_smtp, email_smtp_cliente FROM {cartera}.tb_notificaciones WHERE  id_estatus =".$consecutivo->id )) as $smtpcliente){
                
                if($smtpcliente->email_smtp_cliente){
                    $consecutivo->email_smtp_cliente = 1 ;
                }else{
                    $consecutivo->email_smtp_cliente = 0 ;

                }
                if($smtpcliente->email_smtp){
                    $consecutivo->email_smtp = 1 ;
                }else{
                    $consecutivo->email_smtp = 0 ;

                }
                
            }
            
        }

        $carrito->producto = self::query("SELECT * FROM {cartera}.cat_productos WHERE id=" . $carrito->id_producto,[],self::FETCH_ONE);
        $carrito->cliente = self::query("SELECT * FROM {cartera}.tb_clientes WHERE id=" . $carrito->id_cliente,[],self::FETCH_ONE);
        $carrito->opciones = self::query("SELECT o.id,p.nombre,p.tipo,o.value,o.precio FROM {cartera}.tb_carrito_opciones as o INNER JOIN {cartera}.cat_opciones as p ON p.id=o.id_opcion WHERE id_carrito=" . $carrito->id);

        return $carrito;

    }


    public static function allAdmin()
    {
        if($_SESSION['sivoz_auth']->permiso ==  9){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 0 OR v.estatus = 13 OR v.estatus = 2");
        }else if($_SESSION['sivoz_auth']->permiso ==  6){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 1");
        }else if($_SESSION['sivoz_auth']->permiso ==  3){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8");
        }else{
        return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto");
        }
    }


    public static function pendientes(){

        $carritos = self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus, p.generacion, p.nombre as producto, p.tipoWeb , CONCAT(c.empresa,' ') as cliente , c.nombre as nombre , c.apellidos as apellido   FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8");
      
        foreach($carritos as $carrito){
            $carrito->opciones = self::query("SELECT o.id,p.nombre,p.tipo,o.value,o.precio FROM {cartera}.tb_carrito_opciones as o INNER JOIN {cartera}.cat_opciones as p ON p.id=o.id_opcion WHERE id_carrito=" . $carrito->id);
        }


        return $carritos;

    }

    public static function pendiente($id){

        $carrito = (self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus, p.generacion, p.nombre as producto, p.tipoWeb , CONCAT(c.empresa,' ') as cliente , c.nombre as nombre , c.apellidos as apellido   FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.id = ".$id." AND v.estatus = 8"))[0];
      
        
        $carrito->opciones = self::query("SELECT o.id,p.nombre,p.tipo,o.value,o.precio FROM {cartera}.tb_carrito_opciones as o INNER JOIN {cartera}.cat_opciones as p ON p.id=o.id_opcion WHERE id_carrito=" . $carrito->id);



        return $carrito;

    }
    public static function opciones($id){

      
        
        $carrito = self::query("SELECT o.id,p.nombre,p.tipo,o.value,o.precio FROM {cartera}.tb_carrito_opciones as o INNER JOIN {cartera}.cat_opciones as p ON p.id=o.id_opcion WHERE id_carrito=" . $id);



        return $carrito;

    }

    public static function vdc()
    {
        if($_SESSION['sivoz_auth']->permiso ==  9){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 0 OR v.estatus = 13 OR v.estatus = 2 AND p.tipoWeb='VDC'");
        }else if($_SESSION['sivoz_auth']->permiso ==  6){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 1 AND p.tipoWeb='VDC'");
        }else if($_SESSION['sivoz_auth']->permiso ==  3){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8 AND p.tipoWeb='VDC'");
        }else{
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto where p.tipoWeb='VDC'");
        }

    }

    public static function maquinas()
    {
        if($_SESSION['sivoz_auth']->permiso ==  9){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 0 OR v.estatus = 13 OR v.estatus = 2 AND (p.tipoWeb='Maquina Virtual'   or p.tipoWeb ='Servidores Virtuales')");
        }else if($_SESSION['sivoz_auth']->permiso ==  6){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 1 AND (p.tipoWeb='Maquina Virtual'   or p.tipoWeb ='Servidores Virtuales')");
        }else if($_SESSION['sivoz_auth']->permiso ==  3){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8 AND (p.tipoWeb='Maquina Virtual'   or p.tipoWeb ='Servidores Virtuales')");
        }else{
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto where p.tipoWeb='Maquina Virtual'   or p.tipoWeb ='Servidores Virtuales'");
        }

    }

    public static function otros()
    {
        if($_SESSION['sivoz_auth']->permiso ==  9){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 0 OR v.estatus = 13 OR v.estatus = 2 AND p.tipoWeb='Otros'");
        }else if($_SESSION['sivoz_auth']->permiso ==  6){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 1 AND p.tipoWeb='Otros'");
        }else if($_SESSION['sivoz_auth']->permiso ==  3){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8 AND p.tipoWeb='Otros'");
        }else{
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto where p.tipoWeb='Otros'");
        }

    }

    public static function demos()
    {
        if($_SESSION['sivoz_auth']->permiso ==  9){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 0 OR v.estatus = 13 OR v.estatus = 2 AND  p.demo=1");
        }else if($_SESSION['sivoz_auth']->permiso ==  6){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 1 AND  p.demo=1");
        }else if($_SESSION['sivoz_auth']->permiso ==  3){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8 AND  p.demo=1");
        }else{
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto where p.demo=1");
        }
    }

    public static function proximamentes()
    {
        if($_SESSION['sivoz_auth']->permiso ==  9){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 0 OR v.estatus = 13 OR v.estatus = 2 AND p.proximamente=1");
        }else if($_SESSION['sivoz_auth']->permiso ==  6){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 1 AND p.proximamente=1");
        }else if($_SESSION['sivoz_auth']->permiso ==  3){
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto WHERE v.estatus = 8 AND p.proximamente=1");
        }else{
            return self::query("SELECT v.id,v.fecha_pago,v.total,v.fecha_compra,v.estatus,p.nombre as producto,CONCAT(c.empresa,' ') as cliente FROM {cartera}.{model} as v INNER JOIN {cartera}.tb_clientes as c ON c.id=v.id_cliente INNER JOIN {cartera}.cat_productos as p ON p.id=v.id_producto where p.proximamente=1");
        }

    }

    public static function changeEstatus($id,$comment,$estatus,$fecha_aprovisionamiento = false, $precio_aprovisionamiento = false,$usr_notif,$cb)
    {
        if($fecha_aprovisionamiento == false && $precio_aprovisionamiento == false){
            self::queryOneTime("UPDATE {cartera}.{model} SET estatus=$estatus WHERE id=$id");
            $carrito = self::query("SELECT * FROM {cartera}.{model} WHERE id=$id",[],self::FETCH_ONE);

            if($usr_notif == 'NA'){
            }else{
                Alert::crearNuevo($comment, "Mensaje de sistema", 'operacion/carrito?id=' . $id, $carrito->id, 'carrito', $usr_notif);
            }

            Notificacion::send('operacion/carrito?id=' . $id,$estatus,'carrito',$carrito->id,'carrito');

            Alert::create('cliente',$carrito->id_cliente,'Cambio de estatus de compra',$comment,'administracion/carrito?id=' . $id,$carrito->id,'carrito');
        }else if($precio_aprovisionamiento == false){
            
            self::queryOneTime("UPDATE {cartera}.{model} SET estatus=$estatus,fecha_aprovisionamiento='$fecha_aprovisionamiento' WHERE id=$id");
            $carrito = self::query("SELECT * FROM {cartera}.{model} WHERE id=$id",[],self::FETCH_ONE);

            if($usr_notif == 'NA'){
            }else{
                Alert::crearNuevo($comment, "Mensaje de sistema", 'operacion/carrito?id=' . $id, $carrito->id, 'carrito', $usr_notif);
            }


            Notificacion::send('operacion/carrito?id=' . $id,$estatus,'carrito',$carrito->id,'carrito');

            Alert::create('cliente',$carrito->id_cliente,'Cambio de estatus de compra',$comment,'administracion/carrito?id=' . $id,$carrito->id,'carrito');

        }else{
            self::queryOneTime("UPDATE {cartera}.{model} SET estatus=$estatus,precio_aprovisionamiento=$precio_aprovisionamiento WHERE id=$id");
            $carrito = self::query("SELECT * FROM {cartera}.{model} WHERE id=$id",[],self::FETCH_ONE);

            if($usr_notif == 'NA'){
            }else{
                Alert::crearNuevo($comment, "Mensaje de sistema", 'operacion/carrito?id=' . $id, $carrito->id, 'carrito', $usr_notif);
            }


            Notificacion::send('operacion/carrito?id=' . $id,$estatus,'carrito',$carrito->id,'carrito');

            Alert::create('cliente',$carrito->id_cliente,'Cambio de estatus de compra',$comment,'administracion/carrito?id=' . $id,$carrito->id,'carrito');
           
        }

        $cb(true);
    }

    public static function fromUser()
    {
        $id = Session::get('sivoz_auth')->id;

        $carritos = self::query("SELECT * FROM {cartera}.{model} WHERE id_cliente=$id");
        
        foreach($carritos as $carrito){
            $carrito->producto = self::query("SELECT * FROM {cartera}.cat_productos WHERE id=" . $carrito->id_producto,[],self::FETCH_ONE);
            $carrito->cliente = self::query("SELECT * FROM {cartera}.tb_clientes WHERE id=" . $carrito->id_cliente,[],self::FETCH_ONE);
            $carrito->opciones = self::query("SELECT o.id,p.nombre,p.tipo,o.value,o.precio FROM {cartera}.tb_carrito_opciones as o INNER JOIN {cartera}.cat_opciones as p ON p.id=o.id_opcion WHERE id_carrito=" . $carrito->id);
        }

        return $carritos;
    }
	
	 public static function all()
    {
        
        $productos = self::query("SELECT * FROM {cartera}.{model}");
       
        return $productos;
    }

    public static function allDetalle()
    {
        
        $productos = self::query("SELECT * FROM {cartera}.{model}");

        foreach($productos as $producto){
            $producto->test = "Nice";
        }
       
        return $productos;
    }
    public static function getById($id)
    {
        
        $carrito = self::query("SELECT * FROM {cartera}.{model} WHERE id = ".$id.";");

        return $carrito;
    }


  
}
