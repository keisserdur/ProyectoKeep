<?php

/**
 * Clase encargada de hacer consultas y peticiones a la base de datos.
 * 
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class GestorMedia {
    
    const TABLA = 'media';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    /**
     * Funcion privada que permite a partir de un objeto crear un array ordenado con todos sus campos.
     * 
     * @param objeto que se convertira en array
     * @return array con los valores del objeto.
     */ 
    private static function _getCampos($objeto) {
        $campos = $objeto->get();
        return $campos;
    }

    /**
     * Metodo que recibe una nota ya tratada y este metodo se encarga de generar un consulta a traves de
     * una instancia de DataBase. En caso de crear la nota tambien crea una edicion. Si no llega a insertar
     * la nota devuelve -1.
     * 
     * @param objeto nota a insertar
     * 
     * @return int id.
     */
    function add(Media $objeto) {
        $campos = self::_getCampos($objeto);
        unset($campos['idMedia']);
        
        $r = $this->db->insertParameters(self::TABLA, $campos, false);
        
        return $r;
    }
}