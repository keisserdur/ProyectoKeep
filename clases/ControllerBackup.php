<?php

/**
 * Clase que coontrola todas la acciones relacionadas con la notas. 
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class ControllerBackup extends Controller {
    
    /**
     * Metodo que saca de la base de datos la lista de notas y lo muestra en pantalla junto a dos botones,
     * uno para editar la nota y otra para borrarla, el boton de borrar lleva asociado un script de confirmacion
     * 
     * Ejemplo url : https://keep-keisserdur.c9users.io/?ruta=backupajax & accion=viewlist & id=83
     */
    function viewlist() {
        $lista = $this->getModel()->getListBackup(REQUEST::read('id'));
        $dato = '';
        $dato .= $this->json($lista);
        //foreach($lista as $backup) {
            //$dato .= $backup->json();
            //$dato .= '<a href="index.php?ruta=backup&accion=dobackup&id=' . $backup->getIdEdicion() . '">Recuperar</a>';
            //$dato .= '<br>';
        //}
        
        //$dato .= '<a href="index.php?ruta=backup&accion=viewinsert" > Insertar</a>';
        
        $this->getModel()->addData('lista', $dato);
    }
    
    function dobackup() {
        $id = Request::read('id');
        $gestor = new GestorBackup();
        $edicion = $gestor->get($id);
        $gestor->recovery($edicion);
    }
    
    /**
     * 
     * 
     */
    function json($lista){
        $s = '';
        foreach ($lista as $value) {
            $s .= $value->json() . ',';
        }
        
        $s = substr($s, 0, $s.legth-1);
        
        return '{ "r" : [' . $s . '] }';
    }
    
    function json2($lista){
        $s = array();
        foreach ($lista as $value) {
            $s[] = $value->get();
        }
        
        return json_encode($s);
    }
}