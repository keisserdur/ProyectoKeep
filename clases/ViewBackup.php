<?php

class ViewBackup extends View {
    function render() {
        $plantilla = './templates';
        $sesion = Session::getInstance(Constantes::SESSION);
        if($sesion->isLogged()){
            $archivos = $this->getModel()->getFiles();
            foreach($archivos as $indice => $archivo) {
                $this->getModel()->addData($indice, Util::renderFile($plantilla . '/' . $archivo, $this->getModel()->getData()));
            }
            return Util::renderFile($plantilla . '/Notas.html', $this->getModel()->getData());
        }else{
            $sesion->sendRedirect();
        }
    }
}