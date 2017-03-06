<?php

/**
 * 
 * Clase que controla todas la acciones relacionadas con Usuario. 
 *
 * @author Jaime Molina
 * @author Javier Quirosa
 *
 */

class ControllerUsuario extends Controller {
    
    /**
    * 
    * Es la encargada de eliminar un usuario de la base de datos y redireccionar a la lista de todos los usuarios.
    */
    function dodelete() {
        $email = Request::read('email');
        $r = $this->getModel()->deleteUsuario($email);
        header('Location: index.php?ruta=usuario&accion=viewlist&op=delete&r=' . $r);
        exit();
    }
    
    /**
    * 
    * Es la encargada de editar un usuario en la base de datos y redireccionar a la lista de todas los usuarios.
    * Edita solo el email si las pass estan vacias.
    * 
    */
    function doedit() {
        $usuario = new Usuario();
        $usuario->read();
        $newpass = Request::read('password2');
        $repass = Request::read('password3');
        
        if( ($newpass != null && $repass != null && $usuario->getPassword() != null
            || ($newpass != '' && $repass != '' && $usuario->getPassword() != '') ) ){
                
            $usuarioDB = $this->getModel()->getUsuario($email);
            $correcto = password_verify($usuario->getPassword(), $usuarioDB->getPassword());
            
            if($newpass == $repass && $correcto ){
                $usuario->setPassword($newpass);
                $r = $this->getModel()->editUsuario($usuario, $email);
                header('Location: index.php?ruta=usuario&accion=viewlist&op=edit&r=' . $r);
                exit();
            }else{
                $this->viewedit();
            }
        }else{
            $usuario->setPassword(null);
            $r = $this->getModel()->editUsuario($usuario, $email);
            header('Location: index.php?ruta=usuario&accion=viewlist&op=edit&r=' . $r);
            exit();
        }
    }
    
    /**
    * 
    * Es la encargada de insertar un usuario en la base de datos y redireccionar a la lista de todas los usuarios.
    * Desde aqui llamamos a la funcion sendMailsActivation si el usuario que intentamos insertar es correcto.
    * 
    */
    function doinsert() {
        $usuario = new Usuario();
        $usuario->read();
        if($usuario->isValid(Request::read('password2')) ){
            $enviado = Util::sendMailActivation($usuario->getEmail());
            $r = $this->getModel()->insertUsuario($usuario);
            if($r!=-1){
                header('Location: index.php?ruta=usuario&accion=viewlist&op=insert&r=' . $r . "&send=$enviado");
            }else{
                header('Location: index.php?ruta=register&accion=viewinsert&r=' . $r);
            }
            exit();
        }else{
            $this->viewinsert($usuario);
        }
    }
    
    /**
    * 
    * Activamos el usuario a traves de el enlace de activacion que eviamos en el correo.
    * 
    */
    function doActivate() {
        $correo = Request::read("id");
        $s = Request::read("s");
        if( $s === sha1(Constantes::ACTIVATION . $correo) ){
            $this->getModel()->activateUser($correo);
        }
    }
    
    /**
    * 
    * Es el metodo encargado de lanzar el formulario para editar el usuario
    * 
    */
    function viewedit() {
        $id = Request::read('email');
        $error = Request::read('r'); 
        
        if($error == -1){
            $error = 'No se ha editado';
        }
        
        $usuario = $this->getModel()->getUsuario($id);
        $email = $usuario->getEmail();
        
        
        $this->getModel()->addData('email', $email);
        $this->getModel()->addData('error', $error);
        
        $this->getModel()->addFile('form', 'sections/user/formEdit.html');
    }
    
    /**
    * 
    * Es el metodo encargado de lanzar el formulario para insertar usuarios
    * 
    */
    function viewinsert(Usuario $usuario = null) {
        $error = "";
        if($usuario == null){
            $usuario = new Usuario();
        }else{
            $error = '<p class="error">' . "Ha habido un error al registrarse, intentelo de nuevo" . '</p>';
        }
        if(Request::read('r')==-1){
            $error = '<p class="error">' . "Este usuario ya esta registrado" . '</p>';
        }
        $email = $usuario->getEmail();

        $this->getModel()->addData('email', $email);
        $this->getModel()->addData('error', $error);
        
        $this->getModel()->addData('estilos','templates/estilos/register.css');

        $this->getModel()->addFile('form', 'sections/user/formRegister.html');
    }
    
    /**
    * 
    * Es el metodo encargado de lanzar la lista de usuarios
    * 
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
        $dato = '';
        foreach($lista as $usuario) {
            $dato .= $usuario;
            $dato .= '<a class="borrar" href="index.php?ruta=usuario&accion=dodelete&email=' . $usuario->getEmail() . '">borrar este Usuario</a> ';
            $dato .= '<a href="index.php?ruta=usuario&accion=viewedit&email=' . $usuario->getEmail() . '">editar este Usuario</a>';
            $dato .= '<br>';
        }
        $dato .= $datoFinal;
        $dato .= '<a href="index.php?ruta=register&accion=viewinsert" > Insertar</a>';
        $this->getModel()->addData('lista', $dato);
    }
    
    /**
    * 
    * Es el metodo encargado de lanzar el formulario para hacer login en la web
    * 
    */
    function viewLogin(){
        $email=Request::read('email');
        $error='<p class="error">' . Request::read('r') . '</p>';
        
        $this->getModel()->addData('email', $email);
        $this->getModel()->addData('error', $error);
        
        $this->getModel()->addData('estilos','templates/estilos/login.css');
        
        $this->getModel()->addFile('form', 'sections/user/formLogin.html');
    }
    
    /**
    * 
    * Es el metodo encargado de hacer login y crear la sesion del usuario.
    * En el caso de que exista algun error, lo muestra y redirige al index.
    * 
    */
    function dologin(){
        $email = Request::read('email');
        $password = Request::read('password');

        $sesion = Session::getInstance(Constantes::SESSION);
        
        $usuarioDB = $this->getModel()->getUsuario($email);
        
        if($usuarioDB != null){
            $correcto = password_verify($password, $usuarioDB->getPassword());
    
            if($correcto && $usuarioDB->getActiva() == 1){
                $sesion->setUser($usuarioDB);
                $sesion->sendRedirect('index.php?ruta=nota&accion=viewlist');
                exit();
            } else {
                $r="El usuario no esta activado";
            }
        }else{
            $r="El usuario no existe o contraseña equivocada";
        }
        $sesion->destroy();
        $sesion->sendRedirect('index.php?ruta=login&accion=viewlogin&email='.$email.'&r='.$r); //por defecto tiene index.php
    }
    
    /**
    * 
    * Es el metodo encargado de hacer logout del usuario.
    * 
    */
    function dologout(){
        $sesion = Session::getInstance(Constantes::SESSION);
        $sesion->close();
        $sesion->destroy();
        $sesion->sendRedirect();
    }
}