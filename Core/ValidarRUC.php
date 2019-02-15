<?php


namespace Core;


class ValidarRUC
{

    public static function validarRuc($numero = '', $tipo = '')
    {

       

        $NUM_PROVINCIAS = 24;

        // fuerzo parametro de entrada a string
        $numero = (string)$numero;

        if(strlen($numero) == 10 && $tipo == 3) {
            
            return self::validarcedula(substr($numero,0,10));
        }
        
        if($numero == null || strlen($numero) < 13) {
		    return array('error'=>true , 'mensaje'=> 'El ruc requiere 13 digitos');
        }

        if($tipo == 3){
            return self::validarcedula(substr($numero,0,10));
        }else if($tipo == 1){
            return self::validarrucpublico($numero);
        }else if($tipo == 2){
            return self::validarrucprivados($numero);

        }
        
        
        // $prov = intval(substr($numero, 0, 2));

        // if(!(($prov > 0) && ($prov <= $NUM_PROVINCIAS))){
        //     return false;
        // }

        // $prov = intval(substr($numero, 0, 2));

        // $tercer = intval($numero['2']);

        // if(!(($tercer < 6 &&  $tercer >= 0) || ( $tercer == 6 || $tercer == 9))){
        //     return false;
        // }
 
        return array('error'=>false , 'mensaje'=> '');
    }


    public static function validarcedula($strCedula){
        if(is_numeric($strCedula)){
            
            $total_caracteres = strlen($strCedula);
            if($total_caracteres == 10){
                $nro_region = substr($strCedula, 0,2);
                
                if($nro_region>=1 && $nro_region<=24){
                    $ult_digito=substr($strCedula, -1,1);

                    $valor2=substr($strCedula, 1, 1);
                    $valor4=substr($strCedula, 3, 1);
                    $valor6=substr($strCedula, 5, 1);
                    $valor8=substr($strCedula, 7, 1);
                    $suma_pares=($valor2 + $valor4 + $valor6 + $valor8);

                    $valor1=substr($strCedula, 0, 1);
                    $valor1=($valor1 * 2);

                    if($valor1>9){ $valor1=($valor1 - 9); }

                    $valor3=substr($strCedula, 2, 1);
                    $valor3=($valor3 * 2);

                    if($valor3>9){ $valor3=($valor3 - 9); }
                    $valor5=substr($strCedula, 4, 1);
                    $valor5=($valor5 * 2);
                    
                    if($valor5>9){ $valor5=($valor5 - 9); }
                    $valor7=substr($strCedula, 6, 1);
                    $valor7=($valor7 * 2);
                    
                    if($valor7>9){ $valor7=($valor7 - 9); }
                    $valor9=substr($strCedula, 8, 1);
                    $valor9=($valor9 * 2);
                    
                    if($valor9>9){ $valor9=($valor9 - 9); }
                    $suma_impares=($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
                    $suma=($suma_pares + $suma_impares);
                    
                    $dis=substr($suma, 0,1);//extraigo el primer numero de la suma
                    $dis=(($dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
                    $digito=($dis - $suma);
                    if($digito==10){ $digito='0'; }//si la suma nos resulta 10, el decimo digito es cero
                    
                    if ($digito==$ult_digito){//comparo los digitos final y ultimo
                        return array('error'=>false , 'mensaje'=> 'Ruc o cedula Correcto');
                    }else{
                        return array('error'=>true , 'mensaje'=> 'Ruc o cedula Incorrecto');
                    }
                }else{
                    return array('error'=>true , 'mensaje'=> 'Este Nro de ruc o cedula no corresponde a ninguna provincia del ecuador');
                }

            }else{
                return array('error'=>true , 'mensaje'=> 'Es un Numero y tiene solo'.$total_caracteres);
            }
        }else{
            return array('error'=>true , 'mensaje'=> "Este ruc o cedula no corresponde a un Nro de ruc de Ecuador");
        }

       
    }
    public static function validarrucprivados($strCedula){

        $coeficientes = [4,3,2,7,6,5,4,3,2];
        if(is_numeric($strCedula)){
                    
            $nro_region = substr($strCedula, 0,2);
            if($nro_region>=1 && $nro_region<=24){
                
                if($strCedula[2] == 9){

                    $total = 0;
                    for($i = 0; $i < 9 ; ++$i){
                        $total = $total + ( $strCedula[$i] * $coeficientes[$i] );
                    }
                    $residuo = $total % 11;

                    $total = 11 - $residuo;

                    if($total == $strCedula[9]){

                        $digitos = substr($strCedula, 10);

                        if($digitos === '001'){
                            return array('error'=>false , 'mensaje'=> 'valido');

                        }else{
                            return array('error'=>true , 'mensaje'=> $digitos);

                        }

                    }else{

                        return array('error'=>true , 'mensaje'=> 'Ruc no valido');

                    }

                }else{
                    
                    return array('error'=>true , 'mensaje'=> 'El ruc no pertenece a una institucion privada');

                }


            }else{

                return array('error'=>true , 'mensaje'=> 'Este Nro de ruc no corresponde a ninguna provincia del ecuador');

            }


        }
        else{
            return array('error'=>true , 'mensaje'=> "Esta ruc no corresponde a un Nro de ruc de Ecuador");

        }


    }

    public static function validarrucpublico($strCedula){

        $coeficientes = [3,2,7,6,5,4,3,2];
        if(is_numeric($strCedula)){
                    
            $nro_region = substr($strCedula, 0,2);
            if($nro_region>=1 && $nro_region<=24){
                
                if($strCedula[2] == 6){

                    $total = 0;
                    for($i = 0; $i < 8 ; ++$i){
                        $total = $total + ( $strCedula[$i] * $coeficientes[$i] );
                    }
                    $residuo = $total % 11;

                    $total = 11 - $residuo;

                    if($total == $strCedula[8]){

                        if($strCedula[9] == 0){
                            $digitos = substr($strCedula, 10);

                            if($digitos === '001'){
                                return array('error'=>false , 'mensaje'=> 'Ruc valido');
    
                            }else{
                                return array('error'=>true , 'mensaje'=> 'Ruc no valido');
    
                            }
                        }else{

                            return array('error'=>true , 'mensaje'=> 'Ruc no valido');

                        }

                        

                    }else{

                        return array('error'=>true , 'mensaje'=> 'Ruc no valido');

                    }

                }else{
                    
                    return array('error'=>true , 'mensaje'=> 'El ruc no pertenece a una institucion publica');

                }


            }else{

                return array('error'=>true , 'mensaje'=> 'Este Nro de ruc no corresponde a ninguna provincia del ecuador');

            }


        }
        else{
            return array('error'=>true , 'mensaje'=> "Esta ruc no corresponde a un Nro de ruc de Ecuador");
        }


    }
       
}