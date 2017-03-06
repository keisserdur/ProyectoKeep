<?php

class FileUpload {

    const CONSERVAR = 1, REEMPLAZAR = 2, RENOMBRAR = 3;

    private $destino = "../archivos/", $extension = "", $nombre = "", $parametro, $size = 1000000, $prefijo = "", $sesion = "";
    private $error = false, $politica = self::RENOMBRAR;
    private $subido = false, $tipoError = 0;

    /* nombre del parámetro de $_FILES */
    function __construct($parametro) {
        $session = Session::getInstance(Constantes::SESSION);
        
        if (isset($_FILES[$parametro]) && $_FILES[$parametro]["name"] !== "") {
            
            $this->parametro = $parametro;
            
            $nombre = $_FILES[$this->parametro]["name"];
            $trozos = pathinfo($nombre);
            
            $this->prefijo = '$' . $session->getUser()->getId();
            
            $this->nombre = '$' . date('now');
            
            $this->extension = self::_getType($trozos["extension"]);
            $this->nombre = $this->prefijo . $this->nombre . $this->extension;
            
            /* fallo en getExtension  */
        } else {
            $this->error = true;
        }
    }

    /* agregar nuevas extensiones permitidas */
    public function addType($tipo) {
        if (!$this->isType($tipo)) {
            $this->arrayDeTipos[$tipo] = 1;
            return true;
        }
        return false;
    }

    /* nombre que se la pone al archivo */
    function getName() {
        return $this->nombre;
    }

    /* política que se va a seguir */
    function getPolicy() {
        return $this->politica;
    }

    /* tamaño máximo del archivo */
    function getSize() {
        return $this->size;
    }

    /* carpeta destino del archivo */
    function getTarget() {
        return $this->destino;
    }
    
    function getTypeError() {
        return $this->tipoError;
    }

    /* tipo de archivo permitido */
    public function isType($tipo) {
        return self::_compareType([$tipo]);
    }

    /* quitar tipo de archivo permitido */
    public function removeType($tipo) {
        if ($this->isType($tipo)) {
            unset($this->arrayDeTipos[$tipo]);
            return true;
        }
        return false;
    }

    private function renombrar($nombre) {
        $i = 1;
        while (file_exists($this->destino . $nombre . '_' . $i )) {
            $i++;
        }
        return $nombre . '_' . $i;
    }

    /* establecer nombre del archivo */
    function setName($nombre) {
        $this->nombre = $nombre;
    }

    /* establecer política */
    function setPolicy($politica) {
        $this->politica = $politica;
    }

    /* establecer tamaño máximo */
    function setSize($size) {
        $this->size = $size;
    }

    /* establecer destino */
    function setTarget($destino) {
        $this->destino = $destino;
    }

    /* subir archivo */
    public function upload() {
        if ($this->subido) {
            $this->tipoError = 1;
            return false; //no puedo subir dos veces el mismo archivo
        }
        if ($this->error) {
            $this->tipoError = 2;
            return false; //no puedo subir un archivo que no ha llegado
        }
        if ($_FILES[$this->parametro]["error"] != UPLOAD_ERR_OK) {
            $this->tipoError = 3;
            return false; //no puedo subir un archivo que no ha llegado bien
        }
        if ($_FILES[$this->parametro]["size"] > $this->size) {
            $this->tipoError = 4;
            return false; //no puedo subir un archivo que supere el máximo permitido
        }
        if (!$this->isType($this->extension)) {
            $this->tipoError = 5;
            return false; //no puedo subir archivos que no sean de un tipo permitido
        }
        if (!(is_dir($this->destino) && substr($this->destino, -1) === "/")) {
            $this->tipoError = 6;
            return false; //no puedo subir archivos a destinos que no sean carpetas
        }
        if ($this->politica === self::CONSERVAR && file_exists($this->destino . $this->nombre)) {
            $this->tipoError = 7;
            return false; //no puedo subir archivo si ya existe uno que se llame igual, si la política es conservar
        }
        
        //El nombre del archivo que vamos a componer
        if ($this->politica === self::RENOMBRAR && file_exists($this->destino . $this->nombre)) {
            $this->tipoError = -1;
            $nombre = $this->prefijo . $this->renombrar($this->nombre) . $this->extension; //renombro el archivo, si la política es renombrar
        }
        
        if(is_uploaded_file($_FILES[$this->parametro]['tmp_name'])) {
            $this->subido = move_uploaded_file($_FILES[$this->parametro]["tmp_name"],
                                            $this->destino . $this->nombre);
        }
        return $this->subido;
    }
    
    public static function getExtension(){
        $extensiones = array(
            'jpeg' => 85,
            'jpg' => 47,
            'png' => 71,
            'gif' => 12,
            'mp3' => 54,
            'wav' => 94,
            'aac' => 26,
            'ogg' => 73,
            'avi' => 42,
            'mp4' => 10,
            'mov' => 88
        );
        return $extensiones;
    }
    
    private function _getType($nombre){
        $formato = -1;
        $extensiones = self::getExtension();
        if(isset($extensiones[$nombre])){
            $formato = $extensiones[$nombre];    
        }
        return '$' . $formato;
    }
    
    private function _compareType($type){
        $formato = false;
        $extensiones = self::getExtension();
        
        foreach($extensiones as $key => $value){
            if('$'.$value == $type[0]){
                $formato = $key;
                break;
            }
        }
        return $formato;
    }

}