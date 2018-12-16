<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Session;
use \Core\Input;
use \App\Models\User;
use \App\Models\Area;
use \App\Models\Permiso;
use \App\Models\Cartera;
use \App\Models\Estatus;
use \App\Models\Asignacion;
use \App\Models\Menu;
use \App\Models\Grupo;
use \App\Models\Firma;
use \App\Models\Cliente;
use \Core\Router;

class Mantenimiento extends \Core\Controller
{
    public function importar()
    {
        View::render('mantenimiento.importar');
    }

    public function usuarios()
    {
        $users = User::all();
        $areas = Area::all();
        $permisos = Permiso::all();

        View::render('mantenimiento.usuarios', ['users' => $users, 'permisos' => $permisos, 'areas' => $areas]);
    }

    public function asignaciones()
    {
        $carteras = Cartera::all();

        View::render('mantenimiento.asignaciones', ['carteras' => $carteras]);
    }


    public function backup()
    {
        View::render('mantenimiento.backup');
    }

    public function flujoPost()
    {
        $data =  json_decode($_POST['data']);

        foreach($data as $d){
            Estatus::edit($d->id,$d->consecutivos,$d->position->x,$d->position->y);
        }
    }

    public function flujo()
    {
        View::render('mantenimiento.flujo', ['estatus' => Estatus::flujo()]);
    }

    public function licencias()
    {
        View::render('mantenimiento.licencias');
    }

    public function permisos()
    {
        echo json_encode(Permiso::all());
    }

    public function createUser()
    {
        User::create($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });

    }

    public function editarUsuario()
    {
        if($_POST['type'] == 'password'){
            User::changePasswordByID($_POST, function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });
        }else{
            User::edit($_POST, function($pass){
                if($pass == true){
                    echo json_encode(['error' => false]);
                }else{
                    echo json_encode(['error' => true]);
                }
            });
        }
    }

    public function usuario()
    {
        echo json_encode(User::findById($_GET['id']));
    }

    public function getAsignaciones()
    {
        $asignacion = [
            'cartera' => Cartera::findByID($_GET['cartera']),
            'usuarios' => User::withCartera($_GET['cartera'])
        ];

        echo json_encode($asignacion);
    }

    public function editAsignaciones()
    {
        foreach($_POST['data'] as $user){
            if($user['cartera'] == 'false'){
                Asignacion::delete($_POST['cartera'], $user['oid']);
            }else{
                Asignacion::create($_POST['cartera'], $user['oid']);
            }
        }
    }

    public function cms()
    {
        $routes = Menu::getAll();
        $groups = Grupo::getAll();
        $permisos = Permiso::getAll();
        View::render('mantenimiento.cms', ['routes' => $routes, 'grupos' => $groups,'permisos' => $permisos]);
    }

    public function auth()
    {
        $data = [
            'cartera' => Session::get('sivoz_firma')->cartera,
            'usuario' => Session::get('sivoz_firma')->usuario
        ];
        $firma = Firma::find($data);

        echo json_encode($firma);
    }

    public function ruta()
    {
         echo json_encode(Menu::findById($_GET['id']));
    }

    public function grupo()
    {
         echo json_encode(Grupo::findById($_GET['id']));
    }

    public function editarGrupo()
    {
        Grupo::edit($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function createGroup()
    {
        Grupo::create($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function editarRuta()
    {
        Menu::edit($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function crearRuta()
    {
        Menu::create($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function confirmarCorreo()
    {
        Cliente::confirmarCorreo($_GET['token']);
        return Router::redirect('/');
    }

    public function confirmarCorreoVista()
    {
        View::render('mantenimiento.confirmarcorreo');
    }

    public function sendConfirmationEmail()
    {
        Cliente::sendConfirmationEmail();

        return Router::redirect('/');
    }

    #new
}
