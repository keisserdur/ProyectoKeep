<?php

/**
 * Clase que coontrola todas la acciones relacionadas con la notas. 
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */
class ControllerNota extends Controller {
    
    /**
    * Es la encargada de insertar una nota en la base de datos y redireccionar a la lista de todas las notas.
    */
    function doinsert() {
        $nota = new Notas();
        $nota->read();
        $r = $this->getModel()->insertNota($nota);
        echo $r;
        //header('Location: index.php?ruta=nota&accion=viewlis&op=insert&r=' . $r);
        exit();
    }
    
    /**
    * Es la encargada de borrar una nota en la base de datos y redireccionar a la lista de todas las notas.
    */
    function dodelete() {
        $nota = Request::read('id');
        $r = $this->getModel()->deleteNota($nota);
        header('Location: index.php?ruta=nota&accion=viewlist&op=delete&r=' . $r);
        exit();
    }
    
    /**
    * Es la encargada de editar una nota en la base de datos y redireccionar a la lista de todas.
    */
    function doedit() {
        $nota = new Notas();
        $nota->read();
        $r = $this->getModel()->editNota($nota);
        header('Location: index.php?ruta=nota&accion=viewlist&op=edit&r=' . $r);
        exit();
    }
    
    /**
    * Es el metodo encargado de cargar en el modelo el formulario para insertar notas
    */
    function viewinsert(){
        $this->getModel()->addFile('form', 'sections/nota/formInsert.html');
    }
    
    /**
    * Es el metodo encargado de cargar en el modelo el formulario para editar una nota, 
    * guarda ademas en el modelo los datos de la nota para insertarlos en la plantilla
    */
    function viewedit(){
        $id=Request::read('id');
        
        $nota = $this->getModel()->getNota($id);
        $this->getModel()->addData('titulo', $nota->getTitulo());
        $this->getModel()->addData('contenido', $nota->getContenido());
        $this->getModel()->addData('favorito', $nota->getFavorito());
        $this->getModel()->addData('idNotas', $nota->getId());
        $this->getModel()->addData('idUsuario', $nota->getIdUsuario());
        $this->getModel()->addFile('form', 'sections/nota/formEdit.html');
    }
    
    /**
     * Metodo que saca de la base de datos la lista de notas y lo muestra en pantalla junto a dos botones,
     * uno para editar la nota y otra para borrarla, el boton de borrar lleva asociado un script de confirmacion
     */
    function viewlist() {
        $lista = $this->getModel()->getList();
        $datoFinal = <<<DEF
        <script>
        var confirmarBorrar = function(evento) {
            var objeto = evento.target;
            var r = confirm('Borrar?');
            if (r) {
            } else {
                evento.preventDefault();
            }
        }
        var a = document.getElementsByClassName('borrar');
        for (var i = 0; i < a.length; i++) {
            a[i].addEventListener('click', confirmarBorrar, false);
        }
        </script>
DEF;
        $notas = "";
        
        foreach($lista as $nota) {
            $fav = '';
            if($nota->getFavorito() == 1){
                $fav = 'favorita';
            }
            $notas .= '<div id="' . $nota->getId() . '" class="nota ' . $fav . '">';
                $notas .= '<div class="titulo">';
                    $notas .= '<p>' . $nota->getTitulo() . '</p>';
                    if($nota->getFavorito() == 0){
                        $notas .= '<img valor=0 alt="favorito" src="templates/img/notas/estrellavacia.svg">';
                    }else{
                        $notas .= '<img valor=1 alt="favorito" src="templates/img/notas/estrellallena.svg">';
                    }
                $notas .= '</div>';
                $notas .= '<div class="contenido">';
                    $notas .= '<p>' . $nota->getContenido() . '</p>';
                $notas .= '</div>';
                $notas .= '<div class="enlazados">';
                    $notas .= '<div class="miniaturas">';
                        $notas .= '<img alt="archivos enlazadas" src="templates/img/notas/black.play.1.svg">';
                    $notas .= '</div>';
                    $notas .= '<p>+0</p>';
                $notas .= '</div>';
            $notas .= '</div>';
        }
        $this->getModel()->addData('lista', $notas);
        
        $dato .= '<a href="index.php?ruta=nota&accion=viewinsert" > Insertar</a>';
    }
}