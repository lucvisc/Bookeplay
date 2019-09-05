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
        $this->smarty = ConfSmarty::configuration();
    }

    /**
     * Restituisce l'username dell'utente da bloccare/sbloccare dal campodi input
     * Inviato con metodo post
     * @return string contenente l'username dell'utente
     */
    function getUsername(){
        $value = null;
        if (isset($_POST['username']))
            $value = $_POST['username'];
        return $value;
    }

    /**
     * Restituisce l'email dell'utente da bloccare/sbloccare dal campodi input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getEmail(){
        $value = null;
        if (isset($_POST['email']))
            $value = $_POST['email'];
        return $value;
    }

    /**
     * Funzione che permette di visualizzare la pagina home dell'admin (contenente tutti gli utenti della piattaforma),divisi in attivi e bannati.
     * @param $utentiAttivi array di utenti attivi
     * @param $utentiBannati array di utenti bannati
     * @throws SmartyException
     */
    public function showUtenti($utentiAttivi, $utentiBannati, $n_attivi, $n_bannati, $acc, $ban) {
        $this->smarty->assign('acc',$acc);
        $this->smarty->assign('ban',$ban);
        $this->smarty->assign('account',$utentiAttivi);
        $this->smarty->assign('n_attivi',$n_attivi);
        $this->smarty->assign('accountBan',$utentiBannati);
        $this->smarty->assign('n_bannati',$n_bannati);
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
    public function showCrea(EGioeno $giorno) {
        $this->smarty->assign('giorno',$giorno);
        $this->smarty->display('adminCrea.tpl');
    }

}
?>