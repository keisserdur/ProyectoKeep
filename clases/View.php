<?php

class View {

    private $modelo;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
    }

    function getModel() {
        return $this->modelo;
    }

    function render() {
        $plantilla = './templates';
        
        $archivos = $this->getModel()->getFiles();
        foreach($archivos as $indice => $archivo) {
            $this->getModel()->addData($indice, Util::renderFile($plantilla . '/' . $archivo, $this->getModel()->getData()));
        }
        return Util::renderFile($plantilla . '/landing.html', $this->getModel()->getData());
    }
    
}