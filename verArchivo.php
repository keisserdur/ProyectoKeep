<?php
    $mime = '*/*';
    $archivo = '../archivos/$1$1220165_1$71';
    // if(isset($_GET['mime']) && isset($_GET['archivo'])){
    //     $mime = $_GET['mime'];
    //     $archivo = $_GET['archivo'];
    // }
    header('Content-type: ' . $mime);
    readfile($archivo);
    