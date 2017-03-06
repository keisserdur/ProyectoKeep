<?php

/**
 * Clase encargada de hacer consultas y peticiones a la base de datos.
 * 
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class GestorUsuario {
    
    const TABLA = 'usuario';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    /**
     * Funcion privada que permite a partir de un objeto crear un array ordenado con todos sus campos.
     * 
     * @param objeto que se convertira en array
     * @return array con los valores del objeto.
     * 
     */ 
    private static function _getCampos(Usuario $objeto) {
        $campos = $objeto->get();
        return $campos;
    }

    /**
     * Metodo que recibe un usaurio ya tratado y este metodo se encarga de generar un consulta a traves de
     * una instancia de DataBase.
     * 
     * @param objeto usuario a insertar
     * 
     * @return int id.
     * 
     */
    function add(Usuario $objeto) {
        $campos = self::_getCampos($objeto);
        unset($campos['id']);
        return $this->db->insertParameters(self::TABLA, $campos, false);
    }
    
    /**
     * Metodo que a partir del id del usuario lo borra.
     * 
     * @param id Es el identificador numerico del usuario.
     * 
     * @return int id de la fila borrada. 
     * 
     */ 
    function delete($id) {
        return $this->db->deleteParameters(self::TABLA, array('id' => $id));
    }

/**
     * Metodo que a partir del id del usuario lo busca en la base de datos y la devuelve.
     * 
     * @param id Es el identificador numerico del usuario.
     * 
     * @return Usuario.
     * 
     */ 
    function get($id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('email' => $id));
        if ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            return $objeto;
        }
        return null;
    }

    /**
     * Metodo que a busca en la base de datos todas los usuarios.
     * 
     * @return array de Usuarios
     * 
     */ 
    function getList() {
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    /**
     * Metodo que a edita en la base de datos un usuario para el <b>administrador</b>.
     * 
     * @param Usuario usuario a editar.
     * 
     * @return int 1=>editada -1=>error 0=>no editada
     * 
     */
    function saveAdmin(Usuario $objeto) {
        $campos = $this->_getCampos($objeto);
        
        $id = $campos['id'];
        unset($campos['id']);
        unset($campos['falta']);
        unset($campos['activa']);
        
        if($objeto->getPassword() === null || $objeto->getPassword() === ''){
            unset($campos['password']);
        }
        return $this->db->updateParameters(self::TABLA, $campos, array('id' => $id));
    }
    
    /**
     * Metodo que a edita en la base de datos un usuario.
     * 
     * Excepto el id, el tipo, si es activa o no y la fecha de alta
     * 
     * @param Usuario usuario a editar.
     * 
     * @return int 1=>editada -1=>error 0=>no editada
     * 
     */
    function saveUsuario(Usuario $objeto) {
        $campos = $this->_getCampos($objeto);
        
        $id = $campos['id'];
        unset($campos['id']);
        unset($campos['tipo']);
        unset($campos['activa']);
        unset($campos['falta']);
        if($objeto->getPassword() === null || $objeto->getPassword() === ''){
            unset($campos['password']);
        }
        return $this->db->updateParameters(self::TABLA, $campos, array('id' => $id));
    }
    
    /**
     * Metodo que se encarga de editar al usuario en la base de datos para activar su cuenta.
     * 
     * @param string correo que va a ser activado.
     * 
     */
    function activate($correo){
        $campos = array('activa' => 1);
        
        return $this->db->updateParameters(self::TABLA, $campos, array('email' => $correo));
    }

}