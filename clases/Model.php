<?php

class Model {

    private $data = array();
    private $files = array();

    function __construct() {
    }

    function addData($name, $data) {
        $this->data[$name] = $data;
    }

    function addFile($name, $data) {
        $this->files[$name] = $data;
    }

    function getData() {
        return $this->data;
    }

    function getFiles() {
        return $this->files;
    }
}