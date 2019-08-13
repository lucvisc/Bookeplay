<?php
/**
 * La classe VAdmin si occupa dell'input-output per la sezione privata dell'admin
 * @author Luca, Catriel
 * @package View
 */
require_once 'include.php';

class VAdmin {
    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Restituisce l'username dell'utente da bloccare/sbloccare dal campo hidden di input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getUsername(){
        $value = null;
        if (isset($_POST['username']))
            $value = $_POST['username'];
        return $value;
    }

    /**
     * Funzione che permette di visualizzare la pagina home dell'admin (contenente tutti gli utenti della piattaforma),divisi in attivi e bannati.
     * @param $utentiAttivi array di utenti attivi
     * @param $utentiBannati array di utenti bannati
     * @throws SmartyException
     */
    public function showUtenti($utentiAttivi, $utentiBannati) {
        $this->smarty->assign('utenti',$utentiAttivi);
        $this->smarty->assign('utentiBan',$utentiBannati);
        $this->smarty->display('adminAccount.tpl');
    }

    /**
     * Funzione che permette di visualizzare la pagina di modifica delle partite
     * @param $giorno corrisponde alla tabella delle fasce orarie disponibili
     * @throws SmartyException
     */
    public function showPartite ($giorno) {
        $this->smarty->assign('giorno',$giorno);
        $this->smarty->display('adminModifica.tpl');
    }

    /**
     * Funzione che permette di visualizzare la pagina di modifica del conto di un utente
     * @throws SmartyException
     */
    public function showConto() {
        $this->smarty->display('adminConto.tpl');
    }

    /**
     * Funzione che permette di visualizzare la pagina per creare o cancellare una partita
     * @param $partiteAttive array di partite attive
     * @throws SmartyException
     */
    public function showCreaCancella(EBooking $partiteAttive) {
        $this->smarty->assign('partite',$partiteAttive);
        $this->smarty->display('adminPartite.tpl');
    }

    /**
     * Funzione che permette di visualizzare la pagina per creare
     * @param $giorno associazione tra giorno e tutte le fasce orarie
     * @throws SmartyException
     */
    public function showCreaCancella(EGioeno $giorno) {
        $this->smarty->assign('giorno',$giorno);
        $this->smarty->display('adminCrea.tpl');
    }

}
?>