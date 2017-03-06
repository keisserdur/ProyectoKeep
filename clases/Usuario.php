<?php

class Usuario {
    
    private $id,$email, $password, $falta, $tipo, $activa, $pais;
    
    function __construct($id = null, $email = null, $password = null, $falta = null, $tipo = null, $activa = null, $pais =null) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->falta = $falta;
        $this->tipo = $tipo;
        $this->activa = $activa;
        $this->pais = $pais;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getFalta() {
        return $this->falta;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getActiva() {
        return $this->activa;
    }
    
    function getPais(){
        return $this->pais;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setFalta($falta) {
        $this->falta = $falta;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setActiva($activa) {
        $this->activa = $activa;
    }
    
    function setPais($pais){
        $this->pais = $pais;
    }
    
    function __toString() {
        $r = '';
        foreach($this as $key => $valor) {
            $r .= "$key => $valor ---- ";
        }
        return $r;
    }
    
    function read(ObjectReader $reader = null){
        if($reader===null){
            $reader = 'Request';
        }
        foreach($this as $key => $valor) {
            $this->$key = $reader::read($key);
        }
    }
    
    function get(){
        $nuevoArray = array();
        foreach($this as $key => $valor) {
            $nuevoArray[$key] = $valor;
        }
        return $nuevoArray;
    }
    
    function set(array $array, $inicio = 0) {
        $this->id = $array[0 + $inicio];
        $this->email = $array[1 + $inicio];
        $this->password = $array[2 + $inicio];
        $this->falta = $array[3 + $inicio];
        $this->pais = $array[4 + $inicio];
        $this->tipo = $array[5 + $inicio];
        $this->activa = $array[6 + $inicio];
    }
    
    function isValid($password2) {
        if($this->email === null || $this->password === null || $this->email === '' || $this->password === '' || $this->password !== $password2 ){
            return false;
        }
        return true;
    }

}