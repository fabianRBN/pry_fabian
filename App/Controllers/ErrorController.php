<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class ErrorController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function permiso()
    {
        View::render('error.401');
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function sistema()
    {
        View::render('error.500');
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function not_found()
    {
        View::render('error.400');
    }

    #new
}
