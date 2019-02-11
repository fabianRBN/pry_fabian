<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;
use \Core\Router;
use \Core\Session;
use \Core\Input;
use \App\Models\Gestion;
use \App\Models\Codigo;
use \App\Config;

class Reportes extends \Core\Controller
{

    public function gestiones()
    {
        $codigos = Codigo::all();


        if(Input::has('codigo') == false || Input::has('fecha_inicio') == false || Input::has('fecha_fin') == false){


            $gestiones = Gestion::today();
            if(Input::get('tipo') == 'exportacion'){
                if(Input::has('fecha_inicio')  == true || Input::has('fecha_fin') == true){
                    View::export($gestiones, [
                        'codigo' => 'Codigo',
                        'estatus' => 'Estatus',
                        'descripcion' => 'Descripcion',
                        'usuario' => 'Usuario',
                        'cartera' => 'Cartera',
                        'fecha' => 'Fecha',
                    ], 'Reporte de Gestiones <br> <small style="color: #485770;">en un rango de fechas de ' .Input::get('fecha_inicio') . ' a ' . Input::get('fecha_fin') . '</small>', View::slugify('Reporte de Gestiones') . '-' . Input::get('codigo') .'-' . str_replace('-', '', Input::get('fecha_inicio')) . '-' . str_replace('-', '', Input::get('fecha_fin')));
    
                    Router::redirect('reportes/generados');
                }
            }

            View::render('reportes.gestiones', ['gestiones' => $gestiones, 'codigos' => $codigos, 'names' => [
                'codigo' => 'Codigo',
                'estatus' => 'Estatus',
                'descripcion' => 'Descripcion',
                'usuario' => 'Usuario',
                'cartera' => 'Cartera',
                'fecha' => 'Fecha'
            ]]);
        }else{

            $gestiones = Gestion::generate(Input::all());

            if(Input::get('tipo') == 'exportacion'){
                if(Input::has('fecha_inicio')  == true || Input::has('fecha_fin') == true){


                    View::export($gestiones['data'], $gestiones['names'], 'Reporte de Gestiones <br> <small style="color: #485770;">en un rango de fechas de ' .Input::get('fecha_inicio') . ' a ' . Input::get('fecha_fin') . '</small>', View::slugify('Reporte de Gestiones') . '-' . Input::get('codigo') .'-' . str_replace('-', '', Input::get('fecha_inicio')) . '-' . str_replace('-', '', Input::get('fecha_fin')));
    
                    Router::redirect('reportes/generados');
                }
            }

            View::render('reportes.gestiones', ['gestiones' => (array) $gestiones['data'], 'codigos' => $codigos, 'names' => $gestiones['names']]);
        }
        
        
    }

    public function pagos()
    {
        View::render('reportes.pagos');
    }

    public function registros()
    {
        View::render('reportes.registros');
    }

    public function renovaciones()
    {
        View::render('reportes.renovaciones');
    }

    public function terminados()
    {
        View::render('reportes.terminados');
    }
    public function generados()
    {
        $files = scandir(Config::Folder . 'reportes');
        $reportes = [];
        foreach($files as $file){
            if($file == '.' || $file == '..'){

            }else{
                $reportes[] = [
                    'file' => $file,
                    'size' => View::formatBytes(filesize(Config::Folder . 'reportes/' . $file)),
                    'date' => date ("Y-m-d h:i:s",strtotime ( '+1 hour' , strtotime(date ("Y-m-d h:i:s", filemtime(Config::Folder . 'reportes/' . $file))))),
                    'url' => Config::Domain . 'reportes/reporte?download=' . $file
                ];
            }
        }

        usort($reportes, function($a, $b) {
            return ($a['date'] < $b['date']) ? -1 : 1;
        });

        $reportes = array_reverse($reportes);
        View::render('reportes.generados', ['reportes' => $reportes]);
    }

    public function reporte()
    {
        if(Input::get('download')){
            header('Content-type: text/xml');
            header('Content-Disposition: attachment; filename="'.  Input::get('download') .'"');
    
            echo file_get_contents(Config::Folder . 'reportes/' . Input::get('download'));
        }else{
            header('Content-type: text/xml');
            header('Content-Disposition: attachment; filename="'.  Input::get('archivo') .'"');
    
            echo file_get_contents(Config::Folder . 'Documents/' . Input::get('archivo'));
        }
        
        exit();
    }

    #new

}
