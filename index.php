<?php

require_once 'ConfSmarty.php';
require_once 'Installation.php';
require_once 'include.php';

    $fcontroller=new CFrontController();
    $fcontroller->run($_SERVER['REQUEST_URI']); //se è stata già fatta si invia al front controller la richiesta

?>
