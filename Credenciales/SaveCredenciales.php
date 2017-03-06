<?php
    //ID de proyecto - jjkeep-2016
    //ID cliente - 711391888672-apm9prff312sj732879u04pu7ifi0slq.apps.googleusercontent.com
    //Secreto - _iAP9bu6HFXhnuTJL283U4Ct
    
    // composer require google/apiclient:^2.0
    // composer require phpmailer/phpmailer
    

session_start();
require_once '../clases/vendor/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('jj-keep-2016');
$cliente->setClientId('448371803955-qs49nk5011h39sa14rgd9qlkqch6hg2c.apps.googleusercontent.com');
$cliente->setClientSecret('iZZ3z58n0jMSQEFIpQWR6z1c');
$cliente->setRedirectUri('https://keep-keisserdur.c9users.io/Credenciales/SaveCredenciales.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');
if (isset($_GET['code'])) {
   $cliente->authenticate($_GET['code']);
   $_SESSION['token'] = $cliente->getAccessToken();
   $archivo = "token.conf";
   $fh = fopen($archivo, 'w') or die("error");
   fwrite($fh, json_encode($cliente->getAccessToken()));
   fclose($fh);
}
?>