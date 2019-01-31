<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Router;
use \Core\Session;
use \Core\Binnacle;
use \App\Models\Gestion;
use \App\Models\Cliente;
use \App\Models\Asignado;
use \App\Models\Carrito;
use \App\Models\Suscripcion;
use \App\Models\User;
use \App\Models\Permiso;
use \App\Models\Estatus;
use \App\Models\Alert;
use \App\Models\Producto;

class Operacion extends \Core\Controller
{

    public function clientes()
    {
        View::render('operacion.clientes', ['users' => Cliente::all()]);
    }

    public function cliente()
    {
        View::render('operacion.cliente', ['cliente' => Cliente::findByID($_GET['id'])]);
    }

    public function movimientos()
    {
        View::render('operacion.movimientos');
    }
    
	 public function pendientes()
    {
       //return Router::redirectJava('http://192.168.10.65:8080/InterfazGCnt/pendiente.xhtml');
	    //View::render('operacion.pendientes', ['pendientes' => Carrito::allAdmin()]);
		View::render('operacion.pendientes',['carritos' => Carrito::pendientes(),'carritoall'=>carrito::pendientesall()]);
	   
    }

    public function aprovisionarDoc(){

   
        //$carrito = Carrito::opciones($data['id']);

        Binnacle::createDoc($_POST,function($error){
            if($error == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
        
        
    }
    
    public function vdc()
    {
        View::render('operacion.ventasvdc', ['carritos' => Carrito::vdc(), 'carritosall'=>Carrito::vdcall(),'permisos'=>Permiso::permisosUsers()]);
    }
    public function proximamentes()
    {
        echo 'funcion proximamentes';
        View::render('operacion.ventasproximamentes', ['carritos' => Carrito::proximamentes(),'carritosall'=>Carrito::proximamentesall()]);
    }

    public function otros()
    {
        echo 'funcion otros';
        View::render('operacion.ventasotros', ['carritos' => Carrito::otros(),'carritosall'=>Carrito::otrosall()]);
    }

    public function maquinas()
    {
        echo 'funcion maquinas';
        View::render('operacion.ventasvirtual', ['carritos' => Carrito::maquinas(),'carritosall'=>Carrito::maquinasall()]);
    }

    public function demos()
    {
        echo 'funcion demos';
        View::render('operacion.ventasdemos', ['carritos' => Carrito::demos(),'carritosall'=>Carrito::demosall()]);
    }

    public function ventas()
    {
		echo 'Funcion Carrito';
        View::render('operacion.ventas', ['carritos' => Carrito::allAdmin()]);
    }

    public function configuracion()
    {
        
        View::render('operacion.configuracion', ['permisos' =>Permiso::all() ,'estatus'=> Estatus::all(), 'arearnotificadas'=> Permiso::notificadas() ]);
    }

    public function areasnotificadas()
    {
        Permiso::createAreaNotificada($_POST,function($data){
            
                echo json_encode($data);
           
        });
        
    }

    public function deleteAreaNotificada()
    {
        Permiso::deleteAreaNotificada($_POST,function($data){
            
            echo json_encode($data);
       
        });

    }
    
    public function carrito()
    {
		//echo 'Funcion Carrito';
		//echo $_GET['id'];
        View::render('operacion.carrito', ['producto' => Carrito::findByID($_GET['id']), 'alerts' => Alert::get($_GET['id'],'carrito'), 'usuarios' => User::all(),'asignacion'=> Asignado::alldata($_GET['id'])]);
    }

    public function regresion()
    {
        
        if(isset($_POST['fecha_aprovisionamiento'])){
            Carrito::changeEstatus($_POST['id'],$_POST['comentario'],$_POST['estatus'],$_POST['fecha_aprovisionamiento'],false,$_POST['usuario_notificado'],function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });
        }else if(isset($_POST['precio_aprovisionamiento'])){

            Carrito::changeEstatus($_POST['id'],$_POST['comentario'],$_POST['estatus'],false,$_POST['precio_aprovisionamiento'],$_POST['usuario_notificado'],function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });

        }else{
            
            Carrito::changeEstatus($_POST['id'],$_POST['comentario'],$_POST['estatus'],false,false,$_POST['usuario_notificado'],function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });
        }
    }

    public function regresionServicio()
    {
        Suscripcion::changeEstatus($_POST['id'],$_POST['comentario'],$_POST['estatus'],false,function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function readNotifications()
    {
        Alert::read();
    }

    public function suscripcion()
    {
        View::render('operacion.suscripcion', ['producto' => Suscripcion::findByID($_GET['id']), 'alerts' => Alert::get($_GET['id'],'servicio')]);
    }

    public function membresias()
    {
        View::render('operacion.suscripciones', ['servicios' => Suscripcion::allAdmin()]);
    }

    public function notificaciones()
    {
        View::render('operacion.notifications', ['alerts' => Alert::byUser(true)]);
    }

    #new
}
