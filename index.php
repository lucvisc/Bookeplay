<?php

require_once 'ConfSmarty.php';
require_once 'Installation.php';
require_once 'include.php';

 if(Installation::verificaInstallazione()){ //si verifica se l'installazione è stata già fatta
    $fcontroller=new CFrontController();
    $fcontroller->run($_SERVER['REQUEST_URI']); //se è stata già fatta si invia al front controller la richiesta
  }
  // se l'installazione non è stata già fatta viene effettuata
  else{
            Installation::begin();
  }

?>
