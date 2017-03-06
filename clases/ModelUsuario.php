<?php
/**
 * Clase encargada de modelar y preparar los usuarios para poder ser usados tanto para la vista como 
 * para la base de datos.
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class ModelUsuario extends Model {

    /**
    * Recibe un usario para ser insertado en la base de datos
    *
    * @param Usuario usuario
    * @return id o filas insertadas
    */
    function insertUsuario(Usuario $usuario){
        date_default_timezone_set('Europe/Madrid');
        $opciones = array('cost' => 10);
        $clavecifrada = password_hash($usuario->getPassword($clavecifrada), PASSWORD_DEFAULT, $opciones);
        
        $usuario->setFalta(date('Y-m-d'));
        $usuario->setTipo('basico');
        $usuario->setActiva(0);
        $usuario->setPais('null');
        $usuario->setPassword($clavecifrada);
        $gestor = new GestorUsuario();
        return $gestor->add($usuario);
    }
    
    /**
    * Devuelve toda la lista de usuarios sin ningun tipo de filtracion.
    *
    * @return array de usuarios.
    */
    function getList(){
        $gestor = new GestorUsuario();
        return $gestor->getList();
    }
    
    /**
    * Metodo encargado de borrar un usuario segun su email.
    *
    * @param string email del usuario a borrar
    * @return 1=>borrado 0,-1=> no borrrado
    */
    function deleteUsuario($email){
        $gestor=new GestorUsuario();
        return $gestor->delete($email);
    }
    
    /**
    * Metodo que devuelve un usuario en concreto a partir de su email.
    *
    * @param string email del usuario
    * @return Usuario
    */
    function getUsuario($email){
        $gestor = new GestorUsuario();
        return $gestor->get($email);
    }
    
    /**
    * Metodo que edita un usuario en concreto.
    *
    * @param Usuario a editar
    * @return 1=>editado 0,-1=> no editado
    */
    function editUsuario(Usuario $usuario){
        $opciones = array('cost' => 10);
        
        if(!$usuario->getPassword() == null && !$usuario->getPassword() == ''){
            $clavecifrada = password_hash($usuario->getPassword(), PASSWORD_DEFAULT, $opciones);
            $usuario->setPassword($clavecifrada);
        }
        
        $gestor = new GestorUsuario();
        return $gestor->saveUsuario($usuario);
    }
    
    /**
     *Medoto que se encarga de lanzar un correo de activacion a un usuario.
     * 
     * @param string email que se desea enviar el correo
     * 
     * @return string estado del correo.
     */
    function activateUser($email){
        $gestor = new GestorUsuario();
        return $gestor->activate($email);
    }
}