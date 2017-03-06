<?php

class Router {

    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Route('Model', 'View', 'Controller');
        $this->rutas['nota'] = new Route('ModelNota', 'ViewNota', 'ControllerNota');
        $this->rutas['backup'] = new Route ('ModelNota', 'ViewBackup', 'ControllerBackup');
        $this->rutas['usuario'] = new Route ('ModelUsuario', 'ViewUsuario', 'ControllerUsuario');
        $this->rutas['login'] = new Route ('ModelUsuario', 'ViewLogin', 'ControllerUsuario');
        $this->rutas['register'] = new Route ('ModelUsuario', 'ViewLogin', 'ControllerUsuario');

        $this->rutas['backupajax'] = new Route ('ModelNota', 'ViewAjaxBackup', 'ControllerBackup');


    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }

}