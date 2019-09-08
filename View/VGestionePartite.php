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
     * Funzione che permette di acquisire i dati immessi nel campo input, con name=giorno
     * @return mixed|null
     */
    public function getGiorno(){
        $value = null;
        if (isset($_POST['giorno']))
            $value = $_POST['giorno'];
        return $value;
    }

    /**
     * Funzione che permette di acquisire i dati immessi nel campo input, con name=fascia_oraria
     * @return mixed|null
     */
    public function getFasciaOraria(){
        $value = null;
        if (isset($_POST['fascia_oraria']))
            $value = $_POST['fascia_oraria'];
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
     * Funzione che permette di acquisire i dati immessi nel campo input, con name=note
     * @return mixed|null
     */
    public function getNote() {
        $value = null;
        if (isset($_POST['descrizione']))
            $value = $_POST['descrizione'];
        return $value;
    }

        /**
     * Funzione che permette di acquisire i dati immessi nel campo input, con name=livello
     * @return mixed|null
     */
    public function getLivello(){
        $value = null;
        if (isset($_POST['livello']))
            $value = $_POST['livello'];
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
     */
    public function showFormCreation(EUser $utente, EAccount $acc, $img, $part,  $giorno, $error){
            $this->statoForm($error);
            $pic64 = $this->setImage($img, 'user');
            $this->smarty->assign('pic64', $pic64);
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
     * @param $user, $acc informazioni sull' utente da visualizzare
     * @param $part elenco delle partite
     * @param $img immagine dell'utente
     */
    public function showPartite(EUser $user, EAccount $acc, $img, $part, $num) {
        $pic64 = $this->setImage($img, 'user');
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('num', $num);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->assign('array',$part);
        $this->smarty->display('partite.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite attive di un utente non loggato e loggato
     * @param $part elenco delle partite
     * @throws SmartyException
     */
    public function showPartiteAttive($part,$logged, $num,$nmax) {
        $this->smarty->assign('partite', $part);
        $this->smarty->assign('userlogged', $logged);
        $this->smarty->assign('num', $num);
        $this->smarty->assign('nmax', $nmax);
        $this->smarty->display('partiteAttive.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle parite attive di un utente non loggato e loggato
     * @param $part elenco delle partite
     * @throws SmartyException
     */
    public function CercaPartiteAttive($part) {
        $this->smarty->assign('array',$part);
        $this->smarty->display('partiteAttive.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione delle riepilogo delle peartite per un utente loggato
     * @param $user informazioni sull' utente da visualizzare
     * @param $part elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showRiepilogo(EUser $user, EAccount $acc, $img, $part, $num) {
        $pic64 = $this->setImage($img, 'user');
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('num',$num);
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
    public function showVaiAllaPartita(EUser $user, EAccount $acc, $img, $part) {
        $pic64 = $this->setImage($img, 'user');
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('nome', $user->getName());
        $this->smarty->assign('cognome', $user->getSurname());
        $this->smarty->assign('conto', $acc->getConto());
        $this->smarty->assign('partita', $part);
        $this->smarty->display('vaiAllaPartita.tpl');
    }

    /**
     * Funzione che si occupa di presentare la fine della prenotazione
     * @param $user informazioni sull' utente da visualizzare
     * @param $pren elenco delle partite
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showPrenotazioneEffettuata(EUser $user, EAccount $acc, $img, $pren, $num) {  //,$img
        $pic64 = $this->setImage($img, 'user');
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('num',$num);
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
    public function showPrenotazioneErrata(EUser $user, EAccount $acc, $img, $errorNum) {
        $pic64 = $this->setImage($img, 'user');
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('errorNum',$errorNum);
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
            case "no_fascia_oraria":
                $this->smarty->assign('no_fascia_oraria', "errore");
                break;
            case "no_giorno":
                $this->smarty->assign('giorno', "errore");
                break;
        }
    }

    /**
     * Funzione che si occupa del supporto per le immagini
     * @param $image immagine da analizzare
     * @param $tipo variabile che indirizza al tipo di file di default da settare nel caso in cui $image = null
     * @return variabile contenente informazioni dei dati che costituiscono un immagine (possono essere anche degli array)
     */
    public function setImage($image, $tipo) {
        if (isset($image)) {
            $pic64 = base64_encode($image->getData());  //Encodes data with MIME base64
        }
        elseif ($tipo == 'user') {   // file_get_contents returns the file in a string, starting at the specified offset up to maxlen bytes
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/BookAndPlay/Smarty/template/img/user.png');
            $pic64= base64_encode($data);
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/BookAndPlay/Smarty/templete/img/calcio.png');
            $pic64= base64_encode($data);
        }
        return $pic64;
    }

}
?>