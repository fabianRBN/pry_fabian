<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Binnacle;
use \Core\Session;
use \Core\Router;
use \App\Models\User;
use \App\Models\Pais;
use \App\Models\Ciudad;
use \App\Models\Cliente;
use \App\Models\Producto;
use \App\Models\Servicio;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Website extends \Core\Controller
{
    public function home()
    {

        if(!isset($_GET['tipo'])){
            View::render('website.home', ['productos' => Producto::website(1), 'services' => Servicio::allWebsite()]);
        }
        else{
            $opcional = $_GET['tipo'];        
            if($opcional == 1){
                View::render('website.home', ['productos' => Producto::website($opcional), 'services' => Servicio::allWebsite()]);    
            }
            else if($opcional == 2){
                View::render('website.home', ['productos' => Producto::website($opcional), 'services' => Servicio::allWebsite()]);
            }
            else if($opcional == 3){
                View::render('website.home', ['productos' => Producto::website($opcional), 'services' => Servicio::allWebsite()]);
            }
            else if($opcional == 4){
                View::render('website.home', ['productos' => Producto::website($opcional), 'services' => Servicio::allWebsite()]);
            }
            else{
                View::render('website.home', ['productos' => Producto::website($opcional), 'services' => Servicio::allWebsite()]);
            }
        }
        
    }

    public function productos()
    {     
        View::render('website.  ', ['productos' => Producto::website()]);
    }

    public function servicios()
    {
        View::render('website.servicios', ['services' => Servicio::allWebsite()]);
    }

    public function carrito()
    {
        var_dump(Session::get('cart_product_options_1'));
        die();
        View::render('website.carrito');
    }

    public function contacto()
    {
        View::render('website.contacto');
    }

    public function searchProduct()
    {
        $query = $_GET['q'];
        View::render('website.producto', ['producto' => Producto::findById($query)]);
    }
}
