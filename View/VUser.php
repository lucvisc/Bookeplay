<?php
require_once 'include.php';

/**
 * Classe che si occupa dell'input-output dei contenuti riguardanti gli utenti. In particolare della "validazione" dei dati inseriti
 * nelle form richiamando metodi di livello entity e del passaggio degli appositi parametri a Smarty per la costruzione dei template.
 * @package View
 *
 */
class VUser {

    private $smarty;

    public function __construct() {
        $this->smarty = ConfSmarty::configuration();  //configurazione di smarty
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di login
     * @throws SmartyException
     */
    public function showFormLogin(){
        $this->smarty->display('loginSupport.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della homepage dopo il login ( se è andato a buon fine)
     * @param $array elenco delle partite da visualizzare
     * @throws SmartyException
     */
    public function loginOk()
    {
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->display('profilo.tpl');
    }

    public function Homepage(){
        $this->smarty->display('index.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori in fase login
     * @throws SmartyException
     */
    public function loginError()
    {
        $this->smarty->assign('error', "errore");
        $this->smarty->display('loginSupport.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo cliente
     * @param $user informazioni sull' utente da visualizzare
     * @param $acc informazioni dell'utente da visualizzare
     * @param $addr informazioni dell'utente da visualizzare
     * @param $part elenco di partite attive per l'utente
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showProfile(EUser $user, EAccount $acc, EAddress $addr, $pic64)
    {
        //list($type, $pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('nome', $user->getName());
        $this->smarty->assign('cognome', $user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->assign('username', $acc->getUsername());
        $this->smarty->assign('email', $acc->getEmail());
        $this->smarty->assign('telefono', $acc->getTelnumber());
        $this->smarty->assign('datanasc', $user->getDatanasc());
        $this->smarty->assign('gender', $user->getGender());
        //$this->smarty->assign('array', $part);
        $this->smarty->display('profilo.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo cliente
     * @param $user informazioni sull' utente da visualizzare
     * @param $acc informazioni dell'utente da visualizzare
     * @param $addr informazioni dell'utente da visualizzare
     * @param $part elenco di partite attive per l'utente
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function showProfileUser(EUser $user, EAccount $acc, EAddress $addr)
    {
        //list($type, $pic64) = $this->setImage($img, 'user');
        //$this->smarty->assign('type', $type);
        //$this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('nome', $user->getName());
        $this->smarty->assign('cognome', $user->getSurname());
        $this->smarty->assign('conto',$acc->getConto());
        $this->smarty->display('profiloUtente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del cliente
     * @throws SmartyException
     */
    public function showFormRegistration() {
        $this->smarty->display('registerSupport.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori nella form di registrazione per l'utente
     * @param $error tipo di errore da visualizzare
     * @throws SmartyException
     */
    public function registrationError ($error) {
        switch ($error) {
            case "email":
                $this->smarty->assign('errorEmail',"errore");
                break;
            case "typeimg" :
                $this->smarty->assign('errorType',"errore");
                break;
            case "size" :
                $this->smarty->assign('errorSize',"errore");
                break;
        }
        $this->smarty->display('registerSupport.tpl');
    }

    /**
     * Funzione che si occupa del supporto per le immagini
     * @param $image immagine da analizzare
     * @param $tipo variabile che indirizza al tipo di file di default da settare nel caso in cui $image = null
     * @return array contenente informazioni sul tipo e i dati che costituiscono un immagine (possono essere anche degli array)
     */
    public function setImage($image, $tipo) {
        if (isset($image)) {
            $pic64 = base64_encode($image->getData());  //Encodes data with MIME base64
            $type = $image->getType();
        }
        elseif ($tipo == 'user') {   // file_get_contents returns the file in a string, starting at the specified offset up to maxlen bytes
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/BookAndPlay/Smarty/template/img/user.png');
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/BookAndPlay/Smarty/templete/img/calcio.png');
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        return array($type, $pic64);
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica per l'utente
     * @param $user informazioni sull'utente che desidera modificare i suoi dati
     * @param $acc informazioni dell'account relativo all'utente
     * @param $img immagine dell'utente
     * @param $error tipo di errore nel caso in cui le modifiche siano sbagliate
     * @throws SmartyException
     */
    public function formModificaProfilo(EUser $user, EAccount $acc,$error) { // $img,
        switch ($error) {
            case "errorEmail" :
                $this->smarty->assign('errorEmail', "errore");
                break;
            case "errorPassw":
                $this->smarty->assign('errorPassw', "errore");
                break;
            case "errorSize" :
                $this->smarty->assign('errorSize', "errore");
                break;
            case "errorType" :
                $this->smarty->assign('errorType', "errore");
                break;
        }
        if (isset($img)) {
            $pic64 = base64_encode($img->getData());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/BookAndPlay/Smarty/template/img/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('userlogged',"loggato");
        //$this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('username',$acc->getUsername());
        $this->smarty->assign('name',$user->getName());
        //$this->smarty->assign('conto',$acc->getConto());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$acc->getEmail());
        $this->smarty->display('modificaProfilo.tpl');
    }

}
?>