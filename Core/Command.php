<?php 
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
class Command
{
    public function addTitle($title)
    {
       echo $title.PHP_EOL;
    }

    public function addDescription($description)
    {
       echo $description.PHP_EOL;
    }
}
