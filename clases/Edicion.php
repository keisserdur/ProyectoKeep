<?php

/**
 * Clase POPO de Ediciones.
 * 
 * Posee metod get, set,toString y read
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class Edicion {
    private $idEdicion, $idNotas, $titulo, $contenido, $fechaEdicion, $idUsuario;
    
    function __construct($idEdicion = null, $idNotas = null, $titulo = null, $contenido = null, $fechaEdicion = null, $idUsuario = null) {
        $this->idEdicion = $idEdicion;
        $this->idNotas = $idNotas;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->fechaEdicion = $fechaEdicion;
        $this->idUsuario = $idUsuario;
    }
    
    function getIdEdicion() {
        return $this->idEdicion;
    }
    
    function getIdnotas() {
        return $this->idNotas;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getContenido() {
        return $this->contenido;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getFechaEdicion() {
        return $this->favorito;
    }
    
    function setIdEdicion($idEdicion) {
        $this->idEdicion = $idEdicion;
    }

    function setIdNotas($idNotas) {
        $this->idNotas = $idNotas;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    function setFechaEdicion($fechaEdicion) {
        $this->fechaEdicion = $fechaEdicion;
    }   
    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    
    function __toString() {
        $r = '';
        foreach($this as $key => $valor) {
            $r .= "$key => $valor ---- ";
        }
        return $r;
    }
    
    /**
     * Metodo que a partir de una interfaz, es capaz de leer ya sea por get o por post un objeto edicion,
     * y crea un instancia de edicion.
     */
    function read(ObjectReader $reader = null){
        if($reader===null){
            $reader = 'Request';
        }
        foreach($this as $key => $valor) {
            $this->$key = $reader::read($key);
        }
    }
    
    /**
     * Metodo que a partir de un objeto ya instanciado, genera un array con todos los valores en orden.
     */
    function get(){
        $nuevoArray = array();
        foreach($this as $key => $valor) {
            $nuevoArray[$key] = $valor;
        }
        return $nuevoArray;
    }
    
    /**
    * Metodo que recibe un array con todos los campos de la nota en orden, y son insertados
    * en un objeto de tipo Edicion.
    */
    function set(array $array, $inicio = 0) {
        $this->idEdicion = $array[0 + $inicio];
        $this->idNotas = $array[1 + $inicio];
        $this->titulo = $array[2 + $inicio];
        $this->contenido = $array[3 + $inicio];
        $this->fechaEdicion = $array[4 + $inicio];
        $this->idUsuario = $array[5 + $inicio];
    }
    
    /**
     * Metodo que a partir de un objeto ya instanciado, genera un array con todos los valores en orden.
     */
     function json(){
        return json_encode($this->get());
    }
}