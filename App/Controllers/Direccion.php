<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Session;
use \App\Models\Firma;
use \App\Models\Carrito;
use \App\Models\Producto;
use \App\Models\Suscripcion;
use \App\Models\Servicio;
use \App\Models\Visita;
use \App\Models\Cliente;
use \App\Models\Alert;

class Direccion extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function dashboard()
    {
        if(Session::canSee([1,2]) == true){
            View::render('direccion.supervicion.dashboard');
        }elseif(Session::canSee([7]) == true){
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
        }else{
            View::render('operacion.ventas', ['carritos' => Carrito::allAdmin()]);
        }
    }

    public function conexiones()
    {
        View::render('direccion.supervicion.conexiones', ['firmas' => Firma::all()]);
    }

    public function closeSession()
    {
        Firma::cerrarSession($_POST);

        echo json_encode(['error' => false]);
    }


    public function stats()
    {
        $datasets = [
            Carrito::ventasUltimosMeses(4),
            Carrito::comparativaSG(4),
            Producto::graph(),
            Carrito::comparativaSV(4),
            Cliente::ventasUltimosMeses(4),
            Carrito::retiros(4),
        ];
        
        $data = [
            [
                'title' => 'Ventas en los últimos 4 meses',
                'type' => 'bar',
                'labels' => $datasets[0]['labels'],
                'label' => 'Ventas',
                'dataset' => $datasets[0]['dataset'],
                'colors' => ['#84C5E2','#194A6E','#55A5D5','#2A1B84','#4B54BD']
            ],
            [
                'title' => 'Comparativa entre los solicitado y generado',
                'type' => 'line',
                'labels' =>  $datasets[1]['labels'],
                'label' => 'Solicitado VS Generado',
                'dataset' => $datasets[1]['dataset'],
                'colors' => ['#84C5E2','#194A6E','#55A5D5','#2A1B84','#4B54BD']
            ],
            [
                'title' => 'Productos más vendidos',
                'type' => 'pie',
                'labels' =>  $datasets[2]['labels'],
                'label' => 'Producto',
                'dataset' => $datasets[2]['dataset'],
                'colors' => ['#84C5E2','#194A6E','#55A5D5','#2A1B84','#4B54BD']
            ],
            [
                'title' => 'Solucitudes Vs Ventas',
                'type' => 'line',
                'labels' =>  $datasets[3]['labels'],
                'label' => 'Solicitudes Vs Ventas',
                'dataset' => $datasets[3]['dataset'],
                'colors' => ['#84C5E2','#194A6E','#55A5D5','#2A1B84','#4B54BD']
            ],
            [
                'title' => 'Clientes activos',
                'type' => 'pie',
                'labels' => $datasets[4]['labels'],
                'label' => 'Clientes',
                'dataset' => $datasets[4]['dataset'],
                'colors' => ['#84C5E2','#194A6E','#55A5D5','#2A1B84','#4B54BD']
            ],
            [
                'title' => 'Retiros definitivos',
                'type' => 'line',
                'labels' =>  $datasets[5]['labels'],
                'label' => 'Retiros',
                'dataset' => $datasets[5]['dataset'],
                'colors' => ['#84C5E2','#194A6E','#55A5D5','#2A1B84','#4B54BD']
            ]
        ];

        echo json_encode($data);

    }
    #new
}
