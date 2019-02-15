<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Binnacle;
use \Core\Session;
use \Core\Router;
use \Core\ValidarRUC;
use \App\Models\User;
use \App\Models\Pais;
use \App\Models\Ciudad;
use \App\Models\Cliente;
use \App\Models\TipoCliente;
use \App\Models\Sector;
use \App\Models\Organizacion;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Auth extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function login()
    {
        if(isset($_GET['producto'])){
            Session::set('add_producto', ['id' => $_GET['producto']]);
        }
        if(isset($_GET['servicio'])){
            Session::set('add_servicio', ['id' => $_GET['servicio']]);
        }
        
         Session::get('add_producto');
        
        View::render('auth.login');
    }

    public function logout()
    {
        if(Session::get('sivoz_auth')){
            User::logout();
            if(isset($_SESSION['CREATED'])){
                unset($_SESSION['CREATED']);
            }
        }

        
        Router::redirect('/');



    }

    public function loginPost()
    {

        
        if(isset($_SESSION['tokenCSRF'])){

            $token = str_replace(' ', '',$_POST['tokenCSRF']);
            $tokenlocal = str_replace(' ', '', $_SESSION['tokenCSRF']);
      
             if(strcmp($token, $tokenlocal) === 0){
                unset($_SESSION['tokenCSRF']);


                    $validation = User::validate(['email','password'], $_POST);
                    if(isset($_SESSION['intentos'])){
                        if($_SESSION['intentos']>2){
                            Router::redirect('/connect');
                        }
                        $_SESSION['intentosfecha'] = getdate();
                        $_SESSION['intentos'] = $_SESSION['intentos'] + 1;
                        
                       
                    }else{
                        $_SESSION['intentosfecha'] = getdate();
                        $_SESSION['intentos'] = 0;
                    }
                    if($validation === true){
                        $auth = User::login($_POST);

                        if($auth === true){
                            unset($_SESSION['intentos']);
                            unset($_SESSION['intentosfecha']);

                            if(Session::has('add_producto')){
                                $id = Session::get('add_producto');
                                if(Session::get('sivoz_auth')->permiso == 7){
                                    Session::remove('add_producto');
                                    Router::redirect('/tienda/producto?id=' . $id->id);
                                }else{
                                    Router::redirect('/administracion');
                                }
                            }else{
                                Router::redirect('/administracion');
                            }
                            if(Session::has('add_servicio')){
                                $id = Session::get('add_servicio');
                                if(Session::get('sivoz_auth')->permiso == 7){
                                    Session::remove('add_servicio');
                                    Router::redirect('/tienda/servicio?id=' . $id->id);
                                }else{
                                    Router::redirect('/administracion');
                                }
                            }else{
                                Router::redirect('/administracion');
                            }
                            
                        }else{
                            foreach($auth as $a => $value){
                                Session::set($a,$value);
                            }
                        
                            Router::redirect('/connect');
                        }
                    }else{
                    
                        Router::redirect('/connect');
                    }
                }else{
                
                    Router::redirect('/connect');

                }
            }else{
            
                Router::redirect('/connect');

            }

       
    }

    public function log()
    {
        if(!isset($_GET['date'])){
            $date = date('Ymd');
        }else{
            $date = $_GET['date'];
        }

        return Binnacle::show($date);
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function forgot()
    {
        View::render('auth.forgot');
    }

    public function forgotPOST()
    {
        if(Session::verificarTokenForgot($_POST['tokenCSRF'])){
        
            $user = User::byEmail($_POST['email']);

            if($user){
                User::generateResetPassword($user);

                Session::set('reset_password', 'Se te ha enviado un correo para la generación de tu nueva contraseña');

                Router::redirect('forgot');
            }else{


                $cliente = Cliente::byEmail($_POST['email']);
                if($cliente){
                        Cliente::generateResetPassword($cliente);
                        Session::set('reset_password', 'Se te ha enviado un correo para la generación de tu nueva contraseña');
                        Router::redirect('forgot');

                }else{
                    Session::set('email_error', 'Este correo no existe en nuestra base de datos');
                    Router::redirect('forgot');
                }

            }
        }else{
            Router::redirect('forgot');

        }
    }

    public function reset()
    {
        $token = User::resetPassword($_GET['token']);

        if($token){
            View::render('auth.reset', ['token' => $token->token_recuperacion, 'email' => $token->correo]);
        }else{
            $token = Cliente::resetPassword($_GET['token']);
            if($token){
                View::render('auth.reset', ['token' => $token->token_recuperacion, 'email' => $token->correo]);
            }else{
                View::render('auth.reset_error');
            }
        }
    }

    public function resetPost()
    {
        $token = User::resetPasswordVerify($_POST['token'], $_POST['email']);

        if($token){
            $validation = User::validate(['password','password_conf'], $_POST);

            if($validation === true){
                if($_POST['password'] == $_POST['password_conf']){
                    User::changePassword($_POST['email'], $_POST['password']);
                    Router::redirect('/');
                }else{
                    Session::set('password_conf_error', 'Las contraseñas no coinciden');
    
                    Router::redirect('reset?token=' . $_POST['token']);
                }
            }else{
                Router::redirect('reset?token=' . $_POST['token']);
            }

        }else{

            $token = Cliente::resetPasswordVerify($_POST['token'], $_POST['email']);

            if($token){
                $validation = Cliente::validate(['password','password_conf'], $_POST);
                if($validation === true){
                    if($_POST['password'] == $_POST['password_conf']){
                        Cliente::changePassword($_POST['email'], $_POST['password']);
                        Router::redirect('/');
                    }else{
                        Session::set('password_conf_error', 'Las contraseñas no coinciden');
        
                        Router::redirect('reset?token=' . $_POST['token']);
                    }
                }else{
                    Router::redirect('reset?token=' . $_POST['token']);
                }
            }else{
                Router::redirect('/connect');
            }

            
        }
    }

    

    public function register()
    {


        if(isset($_GET['producto'])){
            Session::set('add_producto', ['id' => $_GET['producto']]);
        }

        if(isset($_GET['servicio'])){
            Session::set('add_servicio', ['id' => $_GET['servicio']]);
        }

        $paises = Pais::all();
        View::render('auth.register', ['paises' => $paises, 'sectores' => Sector::all(),'tipo_clientes' => TipoCliente::all()]);
    }

    public function ciudades()
    {
        echo json_encode(Ciudad::findByCountry(Pais::findCode($_GET['pais'])));
    }

    public function paises()
    {
        echo json_encode(Pais::nombres());
    }

    public function organizacion(){

        Organizacion::findById($_POST,function($data){
            
                echo json_encode($data);
          
        });

    }
    

    public function registerPost()
    {
        if(isset($_SESSION['tokenCSRF'])){

        $token = str_replace(' ', '',$_POST['tokenCSRF']);
        $tokenlocal = str_replace(' ', '', $_SESSION['tokenCSRF']);
      
         if(strcmp($token, $tokenlocal) === 0){
            unset($_SESSION['tokenCSRF']);
            $nameinput = ['nombre','apellidos','pais','ciudad','correo','ruc','password','empresa','telefono','direccion','sector','tipo'];
            $validation = Cliente::validate($nameinput, $_POST);            
         if($validation === true){
            $correo = Cliente::emailgroup($_POST['correo']);
            
            if($correo){
                self::registerfuntion($_POST, $nameinput);
            }else if(Cliente::byEmaillike($_POST['correo'])){
                self::registerfuntion($_POST, $nameinput);
                //echo json_encode(Cliente::byEmaillike($_POST['correo']));
            }else{
                Organizacion::create($_POST);
                //echo json_encode(Cliente::byEmaillike($_POST['correo']));
                self::registerfuntion($_POST, $nameinput);
                // Session::set('correo_error','El correo pertenece a una entidad privada');
                // Router::redirect('/register');
            }
         }else{
             Router::redirect('/register');
         } 
    
        }else{Router::redirect('/register');} 
        }else{ Router::redirect('/register');}
       
    
        
    }

    public function registerfuntion($data,$nameinput)
    {
        $ruc = ValidarRuc::validarRuc($data['ruc'],$data['tipo']);
        $correo = Cliente::byEmail($data['correo']);
        

         if($ruc['error']){
             Session::set('ruc_error',$ruc['mensaje']);
             Router::redirect('/register');
         }else if($correo){
             Session::set('correo_error','El correo ya esta registrado');
             Router::redirect('/register');
         }else if(strlen($data['telefono']) < 10 ){
             Session::set('telefono_error','El número de teléfono es valido');
             Router::redirect('/register');
         }else {
             $auth = Cliente::create($data);
             if($auth === true){
                 Cliente::login($data);
                 if(Session::has('add_producto')){
                     $id = Session::get('add_producto');
                     if(Session::get('sivoz_auth')->permiso == 7){
                         Session::remove('add_producto');
                         Router::redirect('/tienda/producto?id=' . $id->id);
                     }else{
                         Cliente::clearSession($nameinput);
                         Router::redirect('/administracion');
                     }
                 }else{
                     Cliente::clearSession($nameinput);
                     Router::redirect('/administracion');
                 }
                 if(Session::has('add_servicio')){
                     $id = Session::get('add_servicio');
                     if(Session::get('sivoz_auth')->permiso == 7){
                         Session::remove('add_servicio');
                         Router::redirect('/tienda/servicio?id=' . $id->id);
                     }else{
                         Cliente::clearSession($nameinput);
                         Router::redirect('/administracion');
                     }
                 }else{
                     Cliente::clearSession($nameinput);
                     Router::redirect('/administracion');
                 }
             }else{
                 foreach($auth as $a => $value){
                     Session::set($a,$value);
                     Router::redirect('/register');
                 }
             }
         }
    }

    #new
}
