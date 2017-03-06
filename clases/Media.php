<?php

/**
 * Clase POPO de Media.
 * 
 * Posee metod get, set,toString y read
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class Media {
    private $idMedia, $idNotas, $tipo, $ruta;
    
    function __construct($idMedia = null, $idNotas = null, $tipo = null, $ruta = null) {
        $this->idMedia = $idMedia;
        $this->idNotas = $idNotas;
        $this->tipo = $tipo;
        $this->ruta = $ruta;
    }
    
    function getIdMedia() {
        return $this->idMedia;
    }

    function getIdNotas() {
        return $this->idNotas;
    }

    function getTipo() {
        return $this->tipo;
    }

    function gegRuta() {
        return $this->ruta;
    }

    function setIdMedia($id) {
        $this->idMedia = $id;
    }
    
    function setIdNotas($idNotas) {
        $this->idNotas = $idNotas;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setRuta($ruta) {
        $this->ruta = $ruta;
    }
   
    
    function __toString() {
        $r = '';
        foreach($this as $key => $valor) {
            $r .= "$key => $valor ---- ";
        }
        return $r;
    }
    
    /**
     * Metodo que a partir de una interfaz, es capaz de leer ya sea por get o por post un objeto media,
     * y crea un instancia de una media.
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
    * en un objeto de tipo Media.
    */
    function set(array $array, $inicio = 0) {
        $this->idMedia = $array[0 + $inicio];
        $this->idNotas = $array[1 + $inicio];
        $this->tipo = $array[2 + $inicio];
        $this->ruta = $array[3 + $inicio];
    }
}