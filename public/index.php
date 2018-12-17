<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
ini_set('display_errors',1);
header('Access-Control-Allow-Origin: https://smart.cntcloud2.com'); 
header('Access-Control-Allow-Credentials: true');


session_start();
/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');
date_default_timezone_set(App\Config::Timezone);

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes

$routes = Core\Routes::get();

$session = Core\Session::get('sivoz_auth');

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 360) {
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}else if (isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
}

if(Core\Session::get('sivoz_firma') !== false){
    $data = [
        'cartera' => Core\Session::get('sivoz_firma')->cartera,
        'usuario' => Core\Session::get('sivoz_firma')->usuario
    ];
    $firma = App\Models\Firma::find($data);

    if(!$firma){
        Core\Router::redirect('/logout');
    }else{
        if(Core\Session::get('sivoz_auth') !== false){
            /*if(isset(Core\Session::get('sivoz_auth')->verificado)){
                if(Core\Session::get('sivoz_auth')->verificado == 0){
                    if(strpos($_SERVER['QUERY_STRING'], 'mantenimiento/confirmarcorreo') !== false || strpos($_SERVER['QUERY_STRING'], 'mantenimiento/send-confirmation-email') !== false || strpos($_SERVER['QUERY_STRING'], 'mantenimiento/confirmar-correo') !== false){

                    }
                    else{
                        Core\Router::redirect('/mantenimiento/confirmarcorreo');
                    }
                }
            }*/
        }
    }
}
foreach($routes as $route){
    if($route->activo == 1){
        if($route->permisos == 'all'){
            $router->add($route->ruta, ['controller' => $route->controlador, 'action' => $route->accion]);
        }else{
            $permisos = explode(',',$route->permisos);
            $found = false;
            
            foreach($permisos as $permiso){
                if($permiso == $session->permiso){
                    $found = true;
                }
            }

            if($found == true){
                
                $router->add($route->ruta, ['controller' => $route->controlador, 'action' => $route->accion]);
            }else{
                $router->add($route->ruta, ['controller' => 'ErrorController', 'action' => 'permiso']);
            }
        }
    }
}


$router->dispatch($_SERVER['QUERY_STRING']);



