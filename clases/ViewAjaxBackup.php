<?php

class ViewAjaxBackup extends View {
    function render() {
        echo 'Render ajax<br>';
        // echo 'tamaño ' . $this->getModel()->getData();
        // foreach($this->getModel()->getData() as $key => $value){
        //     echo $key. '->'.$value.'<br>';
        // }
        echo $this->getModel()->getData()['lista'];
    }
}