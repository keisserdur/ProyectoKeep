<?php

/**
 * Clase encargada de modelar y preparar las notas para poder ser usadas tanto para la vista como 
 * para la base de datos.
 * 
 * Para poder realizar cualquier operacion sera necesario comprobar que la sesion exista, y $usuario sera obtenido de la sesion siempre,
 * en caso de no existir sesion se redireccionara al index.
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class ModelNota extends Model {
    
    /**
    * Recibe una nota para ser insertada en la base de datos, para ello sera necesario haber iniciado
    * una sesion para poder asociar la nota a un usuario, si no hay sesion no devuelve nada la funcion
    * y es redireccionado el usuario al index
    *
    * @param Notas nota
    * @return id o filas insertadas
    */
    function insertNota(Notas $objeto){
        $session = Session::getInstance(Constantes::SESSION);
        
        if($session->isLogged()){
            /* Preparamos los datos de la nota */
            $usuario = $session->getUser();
            $gestor = new GestorNotas();
            $objeto->setIdUsuario($usuario->getId());
            $idNota = $gestor->add($objeto);
            
            /* Subimos el archivo */
            $archivo = new FileUpload('archivo');
            $subida = $archivo->upload();
            
            if($subida == 1 && $idNota != 1){
                $gestorMedia = new GestorMedia();
                $media = new Media();
                $media->setIdNotas($idNota);
                $media->setRuta($archivo->getName());
                
                $gestorMedia->add($media);
            } 
            
            return $idNota;
        }else{
            $session->sendRedirect();
        }
        
    }
    
    /**
    * Metodo que a partir de la sesion de usuario, devuelve toda la lista de notas sin ningun tipo de filtracion,
    * si no hay sesion no devuelve nada la funcion y es redireccionado el usuario al index
    *
    * @return array de notas.
    */
    function getList(){
        $session = Session::getInstance(Constantes::SESSION);
        
        if($session->isLogged()){
            $usuario = $session->getUser();
            $gestor = new GestorNotas();
            return $gestor->getList($usuario->getId());
        }else{
            $session->sendRedirect();
        }
    }
    
    /**
    * A partir de un id de una nota ya creada, borra al usuario del login dicha nota.
    * si no hay sesion no devuelve nada la funcion y es redireccionado el usuario al index
    *
    * @param int id
    * @return 1=>borrado 0,-1=> no borrrado
    */
    function deleteNota($id){
        $session = Session::getInstance(Constantes::SESSION);
        
        if($session->isLogged()){
            $usuario = $session->getUser();
            $gestor=new GestorNotas();
            return $gestor->delete($usuario->getId(), $id);
        }else{
            $session->sendRedirect();
        }
    }
    
    /**
    * Metodo que devuelve una nota en concreto a partir de su id, es necesario haber hecho login,
    * si no hay sesion no devuelve nada la funcion y es redireccionado el usuario al index.
    *
    * @param int id
    * @return Notas nota
    */
    function getNota($id){
        $session = Session::getInstance(Constantes::SESSION);
        
        if($session->isLogged()){
            $usuario = $session->getUser();
            $gestor = new GestorNotas();
            return $gestor->get($usuario->getId(), $id);
        }else{
            $session->sendRedirect();
        }
    }
    
    /**
    * Metodo que a partir de una nota guarda cualquier cambio realizado en ella en la base de datos,
    * si no hay sesion no devuelve nada la funcion y es redireccionado el usuario al index.
    *
    * @param Notas nota
    * @return 1=>editado 0,-1=> no editado
    */
    function editNota(Notas $objeto){
        $session = Session::getInstance(Constantes::SESSION);
        
        if($session->isLogged()){
            $gestor = new GestorNotas();
            $objeto->setIdUsuario($session->getUser()->getId());
            return $gestor->save($objeto);
        }else{
            $session->sendRedirect();
        }
    }
    function getListBackup($id){
        $session = Session::getInstance(Constantes::SESSION);
        
        if($session->isLogged()){
            $usuario = $session->getUser();
            $gestor = new GestorBackup();
            return $gestor->getList($id,$usuario->getId());
        }else{
            $session->sendRedirect();
        }
    }
}