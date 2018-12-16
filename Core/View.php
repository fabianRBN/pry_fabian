<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
namespace Core;

/**
 * View
 *
 * PHP version 7.0
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        $view = str_replace('.','/', $view);

        $file = dirname(__DIR__) . "/App/Views/$view" . '.php';  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        $template = dirname(__DIR__) . '/App/Views/' . $template;
        extract($args);
        include($template);
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function array2csv($array)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }

    public static function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
    
        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 
    
        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 

    public static function export($data, $columns, $nombre, $file)
    {
        $xls = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
				xmlns:x="urn:schemas-microsoft-com:office:excel"
				xmlns="http://www.w3.org/TR/REC-html40">
				
				<!DOCTYPE html>
				<html>
				<head>
					<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
					<style id="Classeur1_16681_Styles"></style>
				</head>
				<body>
				<table x:str border=0 cellpadding=0 cellspacing=0 width=100% style="border-collapse: collapse">';
        
        $xls .= "<tr><th style='text-align:center; font-size:16px' colspan='". count($columns) ."'>".$nombre."</th></tr>\n";
        $xls .= "<tr><th style='text-align: right; font-size:9px;' colspan='5'>".date("d/m/Y H:i:s")."</th></tr>\n";
        # IMPRIMIR TITULOS
        $xls .= "<tr>";
        foreach($columns as $column => $value){
            $xls .= "<th>". $value ."</th>";
        }
        $xls .= "</tr>";
        
        foreach($data as $valor){
            $xls .= "<tr>";
            foreach($valor as $c => $row){
                if(isset($columns[$c])){
                    $xls .= "<td style='text-align: center;'>".$row."</td>\n";
                }
            }
            $xls .= "</tr>";
        } // FIN WHILE TICKETS
        $xls .= "</table></body>\n</html>";
        
        file_put_contents(\App\Config::Folder .'reportes/'. $file .'.xls', $xls);
    }
}
