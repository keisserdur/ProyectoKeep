<?php

class Controller {

    private $modelo;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
        
        $sesion = Session::getInstance(Constantes::SESSION);
        
        if( $sesion->isLogged() ){
            $this->modelo->addData('ruta-login','<a id="registro" href="index.php?ruta=login&accion=dologout">Logout</a>');
            $this->modelo->addData('login','<a id="registro" href="index.php?ruta=login&accion=dologout">Logout</a>');
            $this->modelo->addData('correo',$sesion->getUser()->getEmail());
            $this->modelo->addData('configuración','<a href="index.php?ruta=index&accion=viewedit&email=' . $sesion->getUser()->getEmail() . '">Configuracion</a>');
            $this->modelo->addData('ruta-registrarse','<a id="registro" href="index.php?ruta=nota&accion=viewlist">Mis notas</a>');
        }else{
            $this->modelo->addData('ruta-login','<a id="registro" href="index.php?ruta=login&accion=viewlogin">Login</a>');
            $this->modelo->addData('ruta-registrarse','<a id="registro" href="index.php?ruta=register&accion=viewinsert">Registrarse</a>');
        }
        
        $this->modelo->addData('cerrar-sesion','<a id="registro" href="index.php?ruta=login&accion=dologout">Cerrar Sesion</a>');
        
        
        $this->modelo->addData('ruta-descrubre', '<a href="index.php#jajamoqui">Descubre mas sobre nosotros</a>');
        
        $this->modelo->addData('form','');
        $this->modelo->addData('lista','');
        $this->modelo->addData('error','');
    }

    function getModel() {
        return $this->modelo;
    }

    /* acciones */

    function main() {
        $this->modelo->addData('contenido','main');
        $this->modelo->addData('titulo','Notas');
        $this->modelo->addData('tituloLargo','Guarda tus Notas');
    }
    
}