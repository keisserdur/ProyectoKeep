<?php

/**
 * Clase POPO de Notas.
 * 
 * Posee metod get, set,toString y read
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class Notas {
    private $idNotas, $titulo, $contenido, $idUsuario, $favorito;
    
    function __construct($id = null, $titulo = null, $contenido = null, $idUsuario = null, $favorito = null) {
        $this->idNotas = $id;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->idUsuario = $idUsuario;
        $this->favorito = $favorito;
    }
    
    function getId() {
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

    function getFavorito() {
        return $this->favorito;
    }

    function setId($id) {
        $this->idNotas = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setFavorito($favorito) {
        $this->favorito = $favorito;
    }   
    
    function __toString() {
        $r = '';
        foreach($this as $key => $valor) {
            $r .= "$key => $valor ---- ";
        }
        return $r;
    }
    
    /**
     * Metodo que a partir de una interfaz, es capaz de leer ya sea por get o por post un objeto notas,
     * y crea un instancia de una nota.
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
     * Metodo que a partir de un objeto ya instanciado, genera un array con todos los valores en orden.
     */
     function json(){
        /*$nuevoArray = '';
        foreach($this as $key => $valor) {
            $nuevoArray .= '"' . $key . '" : "' . $valor . '", ';
        }
        
        $nuevoArray = substr($nuevoArray, 0, $nuevoArray.legth-1);
        
        return ' { ' . $nuevoArray . ' } ';*/
        return json_encode($this->get());
    }
    
    /**
    * Metodo que recibe un array con todos los campos de la nota en orden, y son insertados
    * en un objeto de tipo Notas.
    */
    function set(array $array, $inicio = 0) {
        $this->idNotas = $array[0 + $inicio];
        $this->titulo = $array[1 + $inicio];
        $this->contenido = $array[2 + $inicio];
        $this->idUsuario = $array[3 + $inicio];
        $this->favorito = $array[4 + $inicio];
    }
}