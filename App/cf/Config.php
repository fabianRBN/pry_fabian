<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Site title
     * @var string
     */
    const Title = 'CNT';
    
    /**
     * Client Name
     * @var string
     */
    const ClientName = 'CNT';

    /**
     * Client Name
     * @var string
     */
    const Description = 'Lo que eres';

    /**
     * Dominio
     * @var string
     */
    const Domain = 'http://sivoz.dyndns.info/clientes/innovasys/';

    /**
     * Folder
     * @var string
     */
    const Folder = '/var/www/html/clientes/innovasys/';

    /**
     * Client Logo
     * @var string
     */
    const Logo = 'logo-dark.png';

    /**
     * Site Favicon
     * @var string
     */
    const Favicon = 'favicon.png';
    
    /**
     * timezone
     * @var string
     */
    const Timezone = 'America/Mexico_City';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = '100';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database prefix
     * @var string
     */
    const DB_PREFIX = 'innovasys_';

    /**
     * Database prefix
     * @var string
     */
    const SHA_TOKEN = 'SivozMexico2018Innovasys';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'sivoz1';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;
}
