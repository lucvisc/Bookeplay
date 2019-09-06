<?php
/**
 * Classe che si occupa dell'input-output dei contenuti riguardanti le partite.
 * Inoltre fornisce a Smarty contenuti per la popolare i template
 * @package View
 */

require_once 'include.php';

class VGestionePartite {

    private $smarty;

    /**
     * VGestioneAnnunci constructor.
     */
    public function __construct()
    {
        $this->smarty = ConfSmarty::configuration();
    }
    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=giorno
     * @return mixed|null
     */
    public function getGiorno(){
        $value = null;
        if (isset($_POST['giorno']))
            $value = $_POST['giorno'];
        return $value;
    }

    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=fascia_oraria
     * @return mixed|null
     */
    public function getFasciaOraria(){
        $value = null;
        if (isset($_POST['fascia_oraria']))
            $value = $_POST['fascia_oraria'];
        return $value;
    }

    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=livello
     * @return mixed|null
     */
    public function getNote() {
        $value = null;
        if (isset($_POST['descrizione']))
            $value = $_POST['descrizione'];
        return $value;
    }

        /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=livello
     * @return mixed|null
     */
    public function getLivello(){
        $value = null;
        if (isset($_POST['livello']))
            $value = $_POST['livello'];
        return $value;
    }

    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=num_gioc
     * @return mixed|null
     */
    public function getNumeroGiocatori(){
        $value = null;
        if (isset($_POST['num_gioc']))
            $value = $_POST['num_gioc'];
        return $value;
    }

    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=old_fascia_oraria
     * @return mixed|null
     */
    public function getOldFasciaOraria(){
        $value = null;
        if (isset($_POST['old_fascia_oraria']))
            $value = $_POST['old_fascia_oraria'];
        return $value;
    }
    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, aventi name=new_fascia_oraria
     * @return mixed|null
     */
    public function getNewFasciaOraria(){
        $value = null;
        if (isset($_POST['new_fascia_oraria']))
            $value = $_POST['new_fascia_oraria'];
        return $value;
    }

    /**
     * Funzione che permette di visualizzare la form di modifica della partita
     * @param $prenotazione oggetto prenotazione i cui paramentri sono modificati
     * @throws SmartyException
     */
    public function modificaForm($prenotazione, EUser $utente, EAccount $acc){
        $this->smarty->assign('prenotazione', $prenotazione);
        $this->smarty->assign('nome', $utente->getName());
        $this->smarty->assign('cognome', $utente->getSurname());
        $this->smarty->assign('conto', $acc->getConto());
        $this->smarty->assign('userlogged', 'loggato');
        $this->smarty->display('modificaPrenotazione.tpl');
    }

    /**
     * Metodo richiamato quando un utente crea una partita
     * In caso di errori nella compilazione dei campi della parita, verrà ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente oggetto utente che effettua l'inserimento dei dati nei campi della partita
     * @param $error codice di errore con diversi significati. In base al suo valore verrà eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione della partita
     * @throws SmartyException
     */
    public function showFormCreation(EUser $utente, EAccount $acc, $part, $giorno, $error){
            $this->statoForm($error);
            $this->smarty->assign('nome', $utente->getName());
            $this->smarty->assign('cognome', $utente->getSurname());
            $this->smarty->assign('conto', $acc->getConto());
            $this->smarty->assign('gg',$giorno);
            $this->smarty->assign('array', $part);
            $this->smarty->assign('userlogged', "loggato");
            $this->smarty->display('creaPartita.tpl');
    }

    /**
     * Funzione che si occupa di far visualizzare la pagina di fine creazione della prenotazione
     * @param $idPren id della campagna appena creata.
     */

    public function showFinePrenotazione($idPren, $img){
        $this->smarty->assign('userlogged','userlogged');
        $this->smarty->assign('idPren',$idPren);
        $this->smarty->display('finePrenotazione.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite per un utente loggato
     * @param $user informazioni sull' utente da visualizzare
     * @param $part elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showPartite(EUser $user, EAccount $acc, $img, $part) {
        list($type,$pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->assign('array',$part);
        $this->smarty->display('partite.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite attive di un utente non loggato
     * @param $part elenco delle partite
     * @throws SmartyException
     */
    public function showPartiteAttive($part,$logged) {
        $this->smarty->assign('partite', $part);
        $this->smarty->assign('userlogged', $logged);
        $this->smarty->display('partiteAttive.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite attive di un utente non loggato
     * @param $part elenco delle partite
     * @throws SmartyException
     */
    public function CercaPartiteAttive($part) { //, $num
        $this->smarty->assign('array',$part);
        //$this->smarty->assign('num', $num);
        $this->smarty->display('partiteAttive.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite per un utente loggato
     * @param $user informazioni sull' utente da visualizzare
     * @param $part elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showRiepilogo(EUser $user, EAccount $acc, $img, $part) { //, $part,$img
        list($type,$pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->assign('partita',$part);
        $this->smarty->display('riepilogo.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite per un utente loggato
     * @param $user informazioni sull' utente da visualizzare
     * @param $part elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showVaiAllaPartita(EUser $user, EAccount $acc, $img, $part) { //,$img
        list($type,$pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('nome', $user->getName());
        $this->smarty->assign('cognome', $user->getSurname());
        $this->smarty->assign('conto', $acc->getConto());
        $this->smarty->assign('partita', $part);
        $this->smarty->display('vaiAllaPartita.tpl');
    }

    /**
     * Funzione che si occupa di gestire la prenotazione delle parite per un utente loggato
     * @param $user informazioni sull' utente da visualizzare
     * @param $pren elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showPrenotazioneEffettuata(EUser $user, EAccount $acc, $img, $pren) {  //,$img
        list($type,$pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->assign('partita',$pren);
        $this->smarty->display('prenotazioneEffettuata.tpl');
    }

    /**
     * Funzione che si occupa di gestire la prenotazione di una partita
     * @param $user informazioni sull' utente da visualizzare
     * @param $part elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showPrenotazioneErrata(EUser $user, EAccount $acc, $img) {  //,$img
        list($type,$pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->display('prenotazioneErrata.tpl');
    }

    /**
     * Funzione utile per gestire i vari errori possibili dovuti dall'inserimento dei dati nella form
     * @param $error
     */
    public function statoForm($error) {
        switch ($error) {
            case "no" :
                $this->smarty->assign('successo', "si");
                break;
            case "no_facia_oraria":
                $this->smarty->assign('no_fascia_oraria', "errore");
                break;
            case "no_giorno":
                $this->smarty->assign('giorno', "errore");
                break;
        }
    }

}
?>