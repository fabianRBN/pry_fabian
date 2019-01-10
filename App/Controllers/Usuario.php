<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Router;
use \Core\Session;
use \App\Models\Gestion;
use \App\Models\Permiso;
use \App\Models\Area;
use \App\Models\Cliente;
use \App\Models\Servicio;
use \App\Models\Producto;
use \App\Models\Carrito;
use \App\Models\Suscripcion;
use \App\Models\Alert;

class Usuario extends \Core\Controller
{

    public function tProductos()
    {

        $servicio = Cliente::servicio();

        if($servicio == false){
            View::render('usuario.tienda.servicios', ['servicios' => Servicio::all()]);
        }else{
            if(Suscripcion::active()){
                View::render('usuario.tienda.productos', ['products' => Producto::tienda()]);
            }else{
                $id = Suscripcion::mine()->id;

                View::render('usuario.admin.servicio', ['producto' => Suscripcion::findByID($id), 'alerts' => Alert::getUser($id,'servicio')]);
            }
        }

    }

    public function tProducto()
    {
        if(Session::verificarToken($_GET['token'])){
            $servicio = Cliente::servicio();

            if($servicio == false){
                View::render('usuario.tienda.servicios', ['servicios' => Servicio::all()]);
            }else{
                if(Suscripcion::active()){
                    View::render('usuario.tienda.producto', ['producto' => Producto::findById($_GET['id'])]);
                }else{
                    $id = Suscripcion::mine()->id;

                    View::render('usuario.admin.servicio', ['producto' => Suscripcion::findByID($id), 'alerts' => Alert::getUser($id,'servicio')]);
                }
            }
        }else{
            View::render('error.500');


        }
        
    }

    public function aCarrito()
    {
        $servicio = Cliente::servicio();

        if($servicio == false){
            View::render('usuario.tienda.servicios', ['servicios' => Servicio::all()]);
        }else{
            if(Suscripcion::active()){
                $carrito =  Carrito::findByID($_GET['id']);
                $cliente = Session::get('sivoz_auth');
                if($carrito->id_cliente == $cliente->id){
                    View::render('usuario.admin.carrito', ['producto' =>$carrito, 'alerts' => Alert::getUser($_GET['id'],'carrito')]);
                }else{
                    View::render('error.500'); 
                }

            }else{
                $id = Suscripcion::mine()->id;

                View::render('usuario.admin.servicio', ['producto' => Suscripcion::findByID($id), 'alerts' => Alert::getUser($id,'servicio')]);
            }
        }

    }

    public function carrito()
    {
        if(isset($_SESSION['cart'])){
            $cart = Producto::cart();
        }
        else{
            $cart = [];
        }
        $subtotal = 0;
        $total = 0;

        for($i = 0; $i < count($cart); $i++){
            $subtotal = $subtotal + $cart[$i]->precio;
     
        }

        $total = $subtotal * 1.12;
        $iva = $subtotal * 0.12;

        View::render('website.carrito', ['productos' => $cart, 'subtotal' => $subtotal,'total' => $total, 'iva' => $iva]);

    }

    public function carritoAdmin()
    {
        $cart = Producto::cart();
        $subtotal = 0;
        $total = 0;

        for($i = 0; $i < count($cart); $i++){
            $subtotal = $subtotal + $cart[$i]->precio;
        }

        $total = $subtotal * 1.12;
        $iva = $subtotal * 0.12;

        View::render('usuario.tienda.carrito', ['productos' => $cart, 'subtotal' => $subtotal,'total' => $total, 'iva' => $iva]);
    }

    public function addToCarts()
    {
        
        if(Session::has('cart')){
            $productos = (array) Session::get('cart');
            if (!in_array($_POST['id_producto'], $productos)) {
                $productos[] = $_POST['id_producto'];
            }
            Session::set('cart', $productos);
            Session::set('cart_product_options_' . $_POST['id_producto'], $_POST);
            //Router::redirect('/carrito');
        }else{
            $productos = [];
            $productos[] = $_POST['id_producto'];
            Session::set('cart', $productos);
            Session::set('cart_product_options_' . $_POST['id_producto'], $_POST);
            //Router::redirect('/carrito');
        }
        return json_encode(Session::get('cart_product_options_' . $_POST['id_producto']));
    }

    public function removeToCart()
    {
        $productos = (array) Session::get('cart');
        $productoscarrito=[];
        $i = 0;
        foreach($productos as $producto) {        
            $productoscarrito[$i] = $producto;
            $i++;
        }
        $productos = $productoscarrito;
        for($i = 0; $i < count($productos); $i++){
            if (array_key_exists($i, $productos)) {
                if($productos[$i] == $_GET['producto']){
                    unset($productos[$i]);
                }
            }
        }
        Session::set('cart', $productos);
        Router::redirect('/carrito');
    }

    public function removeToCartAdmin()
    {
        $productos = (array) Session::get('cart');
        $productoscarrito=[];
        $i = 0;
        foreach($productos as $producto) {        
            $productoscarrito[$i] = $producto;
            $i++;
        }
        $productos = $productoscarrito;
        for($i = 0; $i < count($productos); $i++){
            if (array_key_exists($i, $productos)) {
                if($productos[$i] == $_GET['producto']){
                    unset($productos[$i]);
                }
            }
        }
        Session::set('cart', $productos);
        Router::redirect('/administracion/carrito');
    }
    
    public function tServicios()
    {
        View::render('usuario.tienda.servicios', ['servicios' => Servicio::all()]);
    }

    public function tServicio()
    {
        Suscripcion::add($_GET['id'], function($pass, $id){
            Router::redirect('/administracion/servicio?id=' . $id);
        });
    }

    public function perfil()
    {
        View::render('usuario.admin.perfil');
    }

    public function mProducts()
    {
        $servicio = Cliente::servicio();

        if($servicio == false){
            View::render('usuario.tienda.servicios', ['servicios' => Servicio::all()]);
        }else{
            if(Suscripcion::active()){
                View::render('usuario.admin.productos', ['products' => Carrito::fromUser()]);
            }else{
                $id = Suscripcion::mine()->id;

                View::render('usuario.admin.servicio', ['producto' => Suscripcion::findByID($id), 'alerts' => Alert::getUser($id,'servicio')]);
            }
        }

    }

    public function vdc()
    {
        View::render('usuario.tienda.productosvdc', ['products' => Producto::vdc()]);
    }
    public function proximamentes()
    {
        
        View::render('usuario.tienda.productosproximamente', ['products' => Producto::proximamentes()]);
    }

    public function otros()
    {
        
        View::render('usuario.tienda.productosotros', ['products' => Producto::otros()]);
    }

    public function maquinas()
    {
        
        View::render('usuario.tienda.productosvirtual', ['products' => Producto::maquinas()]);
    }

    public function demos()
    {
        
        View::render('usuario.tienda.productosvirtual', ['products' => Producto::demos()]);
    }

    public function mServicio()
    {
        $id = $_GET['id'];

        View::render('usuario.admin.servicio', ['producto' => Suscripcion::findByID($id), 'alerts' => Alert::getUser($id,'servicio')]);
    }

    public function mServicios()
    {
        $servicio = Cliente::servicio();

        if($servicio == false){
            View::render('usuario.tienda.servicios', ['servicios' => Servicio::all()]);
        }else{

            View::render('usuario.admin.servicios', ['products' => Suscripcion::mines()]);
        }
    }

    public function addToCart()
    {
        if(Session::verificarToken($_POST['token'])){

            Carrito::add($_POST, function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });
        }else{
            echo json_encode(['error' => true]);
        } 

        
    }

    public function regresion()
    {

        if(Session::verificarToken($_POST['token'])){
            Carrito::changeEstatus($_POST['id'],$_POST['comentario'],9,false,false,"NA",function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });
        }else{
            echo json_encode(['error' => true]);
        }
        
    }
}
