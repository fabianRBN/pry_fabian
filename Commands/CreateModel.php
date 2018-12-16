<?php
/**
  * D.R. (c) Sivoz México 2018. Conforme al Artículo 17 de la LFDA
*/
class CreateModel extends Command
{
    public $name = 'make:model';

    public function __construct()
    {
        $this->addTitle('Crear un nuevo modelo');
        $this->addDescription('Este comando se utiliza para añadir un nuevo modelo de la base de datos');
    }

    public function run()
    {
        
    }
}
