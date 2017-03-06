<?php

class ViewLogin extends View {
    function render() {
        $plantilla = './templates';
        
        $archivos = $this->getModel()->getFiles();
        foreach($archivos as $indice => $archivo) {
            $this->getModel()->addData($indice, Util::renderFile($plantilla . '/' . $archivo, $this->getModel()->getData()));
        }
        return Util::renderFile($plantilla . '/Login-Register.html', $this->getModel()->getData());
    }
}