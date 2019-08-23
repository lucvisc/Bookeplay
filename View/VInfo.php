<?php

/**
 * La classe VInfo è utilizzata per visualizzare la pagina di informazioni della applicazione
 * @author Luca, Catriel
 * @package View
 */
require_once 'include.php';

class VInfo
{

    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct() {
        $this->smarty = ConfSmarty::configuration();
    }

    /**
     * Mostra la pagina di informazioni dell'applicazione
     */
    public function showInformazioni(){
        //if(//CUtente::isLogged())
        $this->smarty->display('informazioni.tpl');
    }

}
?>