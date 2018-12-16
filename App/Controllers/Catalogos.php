<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Session;
use \Core\Router;
use \App\Models\Gestion;
use \App\Models\Notificacion;
use \App\Models\Estatus;
use \App\Models\Categoria;
use \App\Models\Permiso;
use \App\Models\User;
use \App\Models\Area;
use \App\Models\Servicio;
use \App\Models\Producto;

class Catalogos extends \Core\Controller
{

    public function permisos()
    {
        $permisos = Permiso::getAlls();
        $areas = Area::getAll();
        View::render('catalogos.permisos', ['permisos' => $permisos, 'areas' => $areas]);
    }

    public function downloadMasters()
    {
        $data = Producto::masters();

        for($i = 0; $i < count($data); $i++){
            $data[$i]->venta = ($data[$i]->venta == 1 ? 'Si' : 'No');
            $data[$i]->proximamente = ($data[$i]->proximamente == 1 ? 'Si' : 'No');
            $data[$i]->demo = ($data[$i]->demo == 1 ? 'Si' : 'No');
            $data[$i]->activo = ($data[$i]->activo == 1 ? 'Si' : 'No');
            $data[$i]->configurable = ($data[$i]->configurable == 1 ? 'Si' : 'No');
            $data[$i]->venta_precio_real = ($data[$i]->venta_precio_real == 1 ? 'Si' : 'No');
        }

        $cols = [
            'id' => 'Identificador',
            'nombre' => 'Nombre',
            'precio' => 'Precio',
            'descripcion' => 'Descripción',
            'fecha_creacion' => 'Fecha',
            'categoria' => 'Categoria',
            'tipo_pago' => 'Tipo de pago',
            'venta' => 'Venta',
            'proximamente' => 'Proximamente',
            'demo' => 'Demo',
            'activo' => 'Activo',
            'configurable' => 'Configurable',
            'venta_precio_real' => 'Venta de precio real'
        ];

        View::export($data, $cols, 'Reporte de Maestros', View::slugify('Reporte de maestros'));

        Router::redirect('reportes/generados');
    }
    
    public function estatus()
    {
        $estatus = Estatus::all();
        if(isset($_GET['id'])){
            $es = Estatus::findByIDs($_GET['id']);
        }else{
            $es = false;
        }
        View::render('catalogos.estatus', ['estatus' => $estatus, 'es' =>$es]);
    }
    public function estatusSave()
    {
        if($_POST['action'] == 'new'){
            Estatus::addNew($_POST, function(){
                return Router::redirect('/catalogos/estatus');
            });
        }else{
            Estatus::editVars($_POST, function(){
                return Router::redirect('/catalogos/estatus?id=' . $_POST['id']);
            });
        }
    }
    
    public function categoria()
    {
        $categorias = Categoria::all();
        if(isset($_GET['id'])){
            $cat = Categoria::findBy($_GET['id']);
        }else{
            $cat = false;
        }
        View::render('catalogos.categorias', ['categorias' => $categorias, 'cat' =>$cat]);
    }
    public function categoriaSave()
    {
        if($_POST['action'] == 'new'){
            Categoria::create($_POST, function(){
                return Router::redirect('/catalogos/categoria');
            });
        }else{
            Categoria::edit($_POST, function(){
                return Router::redirect('/catalogos/categoria?id=' . $_POST['id']);
            });
        }
    }

    public function productos()
    {
        $productos = Producto::withCategories();
		
        
        $categorias = Categoria::all();

        View::render('catalogos.productos', ['productos' => $productos, 'categorias' => $categorias]);
    }
    public function producto()
    {
        $producto = Producto::findById($_GET['id']);
        $opcional = $_GET['imagen'];
        if($opcional == 1){
            if(file_exists($producto->imagenPath)){
                try {
                    $im = file_get_contents($producto->imagenPath);
                   
                    $im2 = 'data:image/png;base64,'. base64_encode($im);
                    
                } catch (Exception $e) {
                    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                }
                $producto->imagen= $im2;
    
            }
            
            echo json_encode($producto);
        }
        else{
            
        }
        
        //$im = imagecreatefromjpeg($producto->imagenPath);
        //header('Content-type: image/jpeg');
        //$res = file_get_contents($producto->imagenPath);
        //$res = file_get_contents($producto->imagenPath);
        //$producto->imagen = imagecreatefromstring($res);
 
    }


    public function servicios()
    {
        $servicios = Servicio::all();
        View::render('catalogos.servicios', ['servicios' => $servicios]);
    }

    public function createArea()
    {
        Area::create($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function editArea()
    {
        Area::edit($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function createRol()
    {
        Permiso::create($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function editRol()
    {
        Permiso::edit($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function area()
    {
        echo json_encode(Area::findBy($_GET['id']));
    }
    
    public function permiso()
    {
        echo json_encode(Permiso::findBy($_GET['id']));
    }

    public function createService()
    {
        Servicio::create($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function servicio()
    {
        echo json_encode(Servicio::findById($_GET['id']));
    }

    public function editService()
    {
        Servicio::edit($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function createProduct()
    {
        $post = json_decode(file_get_contents('php://input'));
		Producto::subir($post->product, function($pass){
			if($pass == false){
				echo $pass;
				echo "Se registro error";
				echo json_encode(['error' => true]);                
			}
		});
		
        echo "Inicia el metodo de crear";
    
        Producto::create($post->product, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });


    }

    public function editProduct()
    {
        $post = json_decode(file_get_contents('php://input'));
        Producto::subir($post->product, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
        Producto::edit($post->product, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });

    }

    public function notificaciones()
    {
        $notificaciones = Notificacion::all();
        $permisos = Permiso::all();
        $usuarios = User::all();
        $estatuss = Estatus::all();

        View::render('catalogos.notificaciones', ['notificaciones' => $notificaciones, 'permisos' => $permisos, 'estatuss' => $estatuss, 'usuarios' => $usuarios]);
    }

    public function crearNotificacion()
    {
        Notificacion::crear($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function notificacion()
    {
        echo json_encode(Notificacion::findByID($_GET['id']));
    }

    public function editarNotificacion()
    {
        Notificacion::edit($_POST, function($pass){
            if($pass == true){
                echo json_encode(['error' => false]);
            }else{
                echo json_encode(['error' => true]);
            }
        });
    }

    public function flujo()
    {
        if($_GET['tipo'] == 'carrito'){
            echo 'carrito';
            $producto = Producto::findById($_GET['id']);
            $productos = Producto::all();
        }else{
            echo 'servicio';
            $producto = Servicio::findById($_GET['id']);
            $productos = Servicio::all();
        }

        View::render('catalogos.flujo', ['estatus' => Estatus::flujoEditor($_GET['id'],$_GET['tipo']),'products' => $productos, 'producto' => $producto]);
    }

    public function cloneflujo()
    {
        Estatus::cloneFlow($_GET['tipo'],$_GET['id'],$_GET['from']);

        return Router::redirect('/catalogos/flujo?id=' . $_GET['id'] . '&tipo=' . $_GET['tipo']);
    }

    public function flujoPost()
    {
        Estatus::changeFLujo($_POST['id'],$_POST['data'],$_POST['tipo']);

        return 1;
    }


    #new
}
