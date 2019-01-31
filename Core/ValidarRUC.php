<?php


namespace Core;


class ValidarRUC
{

    public static function validarCedula($numero = '')
    {

         $NUM_PROVINCIAS = 24;

        // fuerzo parametro de entrada a string
        // $numero = (string)$numero;

        
        // if($numero == null || $numero.strlen() != 10) {
		// 	return false;
        // }
        
        // $prov = intval(substr($numero, 0, 2));

        // if(!(($prov > 0) && ($prov <= $NUM_PROVINCIAS))){
        //     return false;
        // }

        // $prov = intval(substr($numero, 0, 2));

        // $tercer = intval($numero['2']);

        // if(!(($tercer < 6 &&  $tercer >= 0) || ( $tercer == 6 || $tercer == 9))){
        //     return false;
        // }



       
        return true;
    }
    
}