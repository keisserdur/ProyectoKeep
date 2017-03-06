<?php

/**
 * Clase encargada de hacer consultas y peticiones a la base de datos.
 * 
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class GestorNotas {
    
    const TABLA = 'notas';
    const EDIT = 'edicion';
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
     * 
     * 
     */
    function json($idUsuario){
        $l = $this->getList($idUsuario);
        $s = '';
        foreach ($l as $value) {
            $s .= $value->json() . ',';
        }
        
        $s = substr($s, 0, $s.legth-1);
        
        return '{ "r" : [' . $s . '] }';
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
    function add(Notas $objeto) {
        $campos = self::_getCampos($objeto);
        unset($campos['idNotas']);
        
        $r = $this->db->insertParameters(self::TABLA, $campos, false);
        $r = $this->db->getId();
        
        if($r!=-1){
            $campos['idNotas'] = $this->db->getId();
            Self::_createBackup($campos);
            
        }
        
        return $r;
    }
    
    
    /**
     * Metodo que a partir de una nota se encarga de editarla en la base de datos. En caso de editar la 
     * nota tambien crea una edicion. Si no llega a editar la nota devuelve -1.
     * 
     * @param Notas nota que se va a editar.
     * 
     * @return int 1=>editada -1=>error 0=>no editada
     * 
     */ 
    function save(Notas $objeto) {
        $campos =self::_getCampos($objeto);
        $idNotas = $campos['idNotas'];
        $idUsuario = $campos['idUsuario'];
        unset($campos['idNotas']);
        unset($campos['idUsuario']);
        // if($objeto->getFavorito() == null){
        //     unset($campos['favorito']);
        // }
        
        $r = $this->db->updateParameters(self::TABLA, $campos, array('idUsuario' =>$idUsuario,'idNotas' => $idNotas) );
        
        if($r!=-1){
            $campos = $this->_getCampos($objeto);
            Self::_createBackup($campos);
        }
        
        return $r;
    }
    
    /**
     * Metodo que a partir del id del usuario y el id de la nota la borra.
     * 
     * @param idUsuario Es el identificador numerico del usuario.
     * @param id Es el identificador numerico de la nota.
     * 
     * @return int id de la fila borrada. 
     */ 
    function delete($idUsuario, $id) {
        return $this->db->deleteParameters(self::TABLA, array('idNotas' => $id, 'idUsuario' => $idUsuario));
    }

    /**
     * Metodo que a partir del id del usuario y el id de la nota la busca en la base de datos y la devuelve.
     * 
     * @param idUsuario Es el identificador numerico del usuario.
     * @param id Es el identificador numerico de la nota.
     * 
     * @return Notas nota.
     */ 
    function get($idUsuario, $id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('idNotas' => $id, 'idUsuario' => $idUsuario));
        if ($fila = $this->db->getRow()) {
            $objeto = new Notas();
            $objeto->set($fila);
            return $objeto;
        }
    }

    /**
     * Metodo que a partir del id del usuario busca en la base de datos todas las notas asociadas.
     * 
     * @param idUsuario Es el identificador numerico del usuario.
     * 
     * @return array de Notas
     */ 
    function getList($idUsuario) {
        $this->db->getCursorParameters(self::TABLA, '*', array('idUsuario' => $idUsuario), 'idNotas DESC');
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Notas();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    
    /**
     * Metodo que a partir de un array con la nota original, ya sea editada o creada, me inserta una edicion.
     * 
     * @param array valores de la nota
     * 
     */ 
    private function _createBackup($campos){
        $edicion = new Edicion();
        $edicion->setIdNotas($campos['idNotas']);
        $edicion->setTitulo($campos['titulo']);
        $edicion->setContenido($campos['contenido']);
        $edicion->setFechaEdicion(date('Y-m-d'));
        $edicion->setIdUsuario($campos['idUsuario']);
        
        $camposEdicion = self::_getCampos($edicion);
        
        unset($camposEdicion['idEdicion']);
        
        $this->db->insertParameters(self::EDIT, $camposEdicion, false);
    }
    
    
    function recovery (Edicion $objeto) {
        $nota = new Nota();
        $nota->setIdUsuario($objeto->getIdUsuario());
        $nota->setIdNotas($objeto->getIdNotas());
        $nota->setTitulo($objeto->getTitulo());
        $nota->setContenido($objeto->getContenido());
        
        self::save($nota);
    }
}