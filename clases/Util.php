<?php

class Util {

    /**
     * Metodo que se encarga de leer un archivo e insertar los datos pertinentes.
     * 
     * @param file ruta del archivo que va a leer.
     * @parem data datos almacenados.
     * 
     * @return texto ya tratado.
     */
    static function renderFile($file, $data) {
        if (!file_exists($file)) {
            echo 'Error: ' . $file . '<br>';
            return '';
        }
        $contenido = file_get_contents($file);
        return self::renderText($contenido, $data);
    }

    /**
     * Metodo que se encarga de sustituir del archivo que se va a ver los datos que le pasamos.
     * 
     * @param text texto que se visualizara.
     * @param data datos almacenados para sustituir del texto
     * 
     * @return texto ya tratado
     */
    static function renderText($text, $data) {
        foreach ($data as $indice => $dato) {
            $text = str_replace('{' . $indice . '}', $dato, $text);
        }
        return $text;
    }
    
    /**
    * Metodo que se encargar de mandar correos a los usuarios.
    * 
    * @param destino direccion de correo del usuario destino.
    * @param alias es lo que veran como emisor.
    * @param asunto el titulo del correo.
    * @param mensaje texto que se enviara.
    * 
    * @return estado final del envio.
    */
    static function sendMail($destino, $alias, $asunto, $mensaje){
        $origen = "jjkeep2016@gmail.com";
        
        require_once 'vendor/autoload.php';
        $cliente = new Google_Client();
        $cliente->setApplicationName('jj-keep-2016');
        $cliente->setAccessToken(file_get_contents('Credenciales/token.conf'));
        $cliente->setClientId('448371803955-qs49nk5011h39sa14rgd9qlkqch6hg2c.apps.googleusercontent.com');
        $cliente->setClientSecret('iZZ3z58n0jMSQEFIpQWR6z1c');
        if ($cliente->getAccessToken()) {
            $service = new Google_Service_Gmail($cliente);
            try {
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->From = $origen;
                $mail->FromName = $alias;
                $mail->AddAddress($destino);
                $mail->AddReplyTo($origen, $alias);
                $mail->Subject = $asunto;
                $mail->Body = $mensaje;
                $mail->preSend();
                $mime = $mail->getSentMIMEMessage();
                $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
                $mensaje = new Google_Service_Gmail_Message();
                $mensaje->setRaw($mime);
                $service->users_messages->send('me', $mensaje);
                return 'enviado';
            } catch (Exception $e) {
                return 'exception';
            }
        } else {
            return 'no enviado';
        }
    }
    
    /**
     * Metodo encargado unicamente de generar correos de activacion de cuentas.
     * 
     * @param correo direccion del correo que nesita ser activado.
     * 
     * @return estado final del envio.
     */
    static function sendMailActivation($correo){
        $alias = "jjkeeep";
        $asunto = "no-reply activation";
        $s = sha1(Constantes::ACTIVATION . $correo);
        $mensaje = "https://keep-keisserdur.c9users.io/index.php?ruta=usuario&accion=doactivate&id=$correo&s=$s";
        
        return Self::sendMail($correo,$alias,$asunto,$mensaje);
    }
    
    function readFile(){
        $mime = '*/*';
        $archivo = '../archivos/';
        if(isset($_GET['mime']) && isset($_GET['archivo'])){
            $mime = $_GET['mime'];
            $archivo .= $_GET['archivo'];
        }
        header('Content-type: ' . $mime);
        readfile($archivo);
    }
}