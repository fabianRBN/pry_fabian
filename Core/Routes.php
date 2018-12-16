<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace Core;

use PDO;
use \Core\Router;
use \App\Models\Grupo;
use \App\Models\Menu;
use \App\Models\Firma;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Routes
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function get()
    {
        if(Session::get('sivoz_auth') !== false){
            return Menu::all();
        }else{
            return Menu::login();
        }  
    }
}


