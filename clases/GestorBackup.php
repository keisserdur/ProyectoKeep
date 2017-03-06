<?php

/**
 * Clase encargada de hacer consultas y peticiones a la base de datos.
 * 
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class GestorBackup {
    
    const TABLA = 'edicion';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }
    
    function get($id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('idEdicion' => $id));
        if ($fila = $this->db->getRow()) {
            $objeto = new Edicion();
            $objeto->set($fila);
            return $objeto;
        }
    }
    
    function getList($idNota , $idUsuario) {
        $this->db->getCursorParameters(self::TABLA, '*', array('idUsuario' => $idUsuario, 'idNotas' => $idNota));
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Edicion();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function recovery (Edicion $objeto) {
        $gestor = new GestorNotas();
        $nota = new Notas();
        $nota->setIdUsuario($objeto->getIdUsuario());
        $nota->setId($objeto->getIdNotas());
        $nota->setTitulo($objeto->getTitulo());
        $nota->setContenido($objeto->getContenido());
        
        $gestor->save($nota);
    }
        
}