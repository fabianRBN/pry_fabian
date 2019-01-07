<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace Core;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Correo
{

    public static function buildEmail()
    {
        $ruta = dirname(__DIR__) . "/logs/email.html";

        $htmlContent = file_get_contents($ruta);

        return $htmlContent;
    }

}