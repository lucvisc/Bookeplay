<?php

/**
 * La classe VInfo è utilizzata per visualizzare la pagina di informazioni della applicazione
 * @author Luca, Catriel
 * @package View
 */
require_once 'include.php';

class VInfo {

    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct() {
        $this->smarty = ConfSmarty::configuration();
    }

    /**
     * Mostra la pagina di informazioni dell'applicazione con il passaggio del parametro logged per capire se un utente
     * è loggato o meno e per adattare il template alla variabile
     */
    public function showInformazioni($logged){
        $this->smarty->assign('userlogged',$logged);
        $this->smarty->display('informazioni.tpl');
    }

}
?>