<?php
/**
 * La classe CGestionePartite implementa funzionalità per l'utente registrato, non registrato e admin, ai quali sarà consentito
 * sotto opportune condizioni di visualizzare le prenotazioni, e partecipare alla prenotazione
 * @author Luca, Catriel
 * @package Controller
 */
require_once 'include.php';

class CGestionePartite {

    /**
     * Funzione utilizzata per visualizzare l'errore
     */
    public function error() {
        $view = new VError();
        $view->error('1');
    }

    /**
     * Funzione che si occupa di mostrare le partite attive
     * 1)sia per l'utente non loggato e loggato questa funzione permette di visualizzare le partite attive
     * senza la possibiltà di poter partecipare
     */
    static function partiteAttive(){
        $view = new VGestionePartite();
        if(CUser::isLogged()){
            if ($_SERVER['REQUEST_METHOD'] == "GET"){
                $view->showPartiteAttive(null,'logged',null, null);
            }
            elseif($_SERVER['REQUEST_METHOD'] == "POST"){
                $gg= self::splitGiorno($view->getGiorno());
                $pm = new FPersistentManager();
                $partite = $pm->load("giorno", $gg, "FBooking");
                $nmax=count($partite);
                for($i=0; $i<count($partite); $i++) {
                    $idP[$i] = $partite[$i]->getIdbooking();
                    $num[] = $pm->CountPartecipanti($idP[$i]);
                }
                $view->showPartiteAttive($partite, 'logged', $num, $nmax);
            }
        }
        else {
            if($_POST['giorno']!=null) {
                $pm = new FPersistentManager();
                $gg = self::splitGiorno($view->getGiorno());
                $partite = $pm->load("giorno", $gg, "FBooking");
                $nmax = count($partite);
                for ($i = 0; $i < count($partite); $i++) {
                    $idP[$i] = $partite[$i]->getIdbooking();
                    $num[] = $pm->CountPartecipanti($idP[$i]);
                }
                $view->showPartiteAttive($partite, 'nouser', $num, $nmax);
            }
            else {
                $view->showPartiteAttive(null,'nouser',null, null);
            }
        }
    }

    /**
     * Questa funzione viene utilizzata per poter disiscrivere un utente dalla prenotazione nel quale partecipa
     * la condizione è che può disiscriversi fino a due giorni prima del giorno della prenotazione
     */
    public static function disdici($id){
        if (CUser::isLogged()){
            $account=unserialize($_SESSION['account']);
            $pm=new FPersistentManager();
            $view= new VGestionePartite();
            $partita=$pm->load('idP', $id, "FBooking");
            $giorno=$partita[0]->getGiornobooking()->getGiorno();
            $today = date("d/m/Y");
            $giorno = strtotime($giorno);
            $today = strtotime($today);
            $diff = abs($giorno - $today);
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            if($days>=1){
                $pm->deletePren_partecipa($id, $account->getEmail());
                $account = EAccount::ripristinaPartita($account);
                $conto = $account->getConto();
                $pm::update('conto', $conto, 'email', $account->getEmail(), "FAccount");
                $acc = $pm->load('email', $account->getEmail(), "FAccount");
                $user = $pm->load('email', $account->getEmail(), "FUser");
                $img = $pm->loadImg($account->getEmail());
                $prenotazione=$pm->loadPrenotazioneEff($_POST['giorno'], $_POST['fascia_oraria']);
                $salvare = serialize($acc);
                $_SESSION['account'] = $salvare;
                $view->showPrenotazioneErrata($user, $acc, $img, 'delete');
            }
            else {
                $acc = $pm->load('email', $account->getEmail(), "FAccount");
                $user = $pm->load('email', $account->getEmail(), "FUser");
                $img = $pm->loadImg($account->getEmail());
                $view->showPrenotazioneErrata($user, $acc, $img, 'no_delete');
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che viene richiamata per la creazione di una partita. Si possono avere diverse situazioni:
     * 1) se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono creare partite
     * se l'utente è loggato
     * 2) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della partita;
     * 3) se il metodo di richiesta HTTP è POST viene creata la prenotazione
     */
    static function creaPartita() {
        if (CUser::isLogged()) {
            $view = new VGestionePartite();
            $pm= new FPersistentManager();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $account = unserialize($_SESSION['account']);
                $img = $pm->loadImg($account->getEmail());
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $view->showFormCreation($user, $account, $img,  null, null ,'no');
            }
            else {
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $account = unserialize($_SESSION['account']);
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $img = $pm->loadImg($account->getEmail());
                    if (EGiorno::verificaGiorno($_POST['giorno'])) {
                        if(EGiorno::verificaFascia($_POST['fascia_oraria'])) {
                            $giorno = new EGiorno($_POST['giorno'], $_POST['fascia_oraria']);
                            $gg = $pm->loadGiorno($_POST['giorno'], $_POST['fascia_oraria']);
                            if (!isset($gg)) {
                                $pm->insertGiorno($giorno);
                                $pren = new EBooking(null, $_POST['livello'], $giorno->getGiorno(), $giorno->getFasceOrarie(), $_POST['descrizione'], null, $account->getEmail());
                                $id = FBooking::store($pren);
                                FPren_partecipa::insert($id, $account->getEmail());
                                $num = $pm->CountPartecipanti($id);
                                $account = EAccount::PagaPartita($account);
                                $conto = $account->getConto();
                                $pm::update('conto', $conto, 'email', $account->getEmail(), "FAccount");
                                $acc = $pm->load('email', $account->getEmail(), "FAccount");
                                $img = $pm->loadImg($account->getEmail());
                                $prenotazione = $pm->loadPrenotazioneEff($_POST['giorno'], $_POST['fascia_oraria']);
                                $newAcc = $pm->load('email', $account->getEmail(), "FAccount");
                                $salvare = serialize($newAcc);
                                $_SESSION['account'] = $salvare;
                                $view->showPrenotazioneEffettuata($user, $acc, $img, $prenotazione, $num); //

                            }
                            else {
                                $view->showFormCreation($user, $account, $img, null, null, "no_giorno");
                            }
                        }
                        else {
                            $view->showFormCreation($user, $account, $img, null, null, "no_fascia_oraria");
                        }
                    }
                    else {
                        $view->showFormCreation($user, $account, $img, null, null, "no_giorno");
                    }
                }
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**Form utilizzata per un utente loggato, questa funzione da la possibilità di partecipare e di essere aggiunto come
     * partecipante ad una specifica prenotazione
     */
    public function partecipa($id){
        if (CUser::isLogged()){
            $view = new VGestionePartite();
            $pm= new FPersistentManager();
            $account = unserialize($_SESSION['account']);
            $img = $pm->loadImg($account->getEmail());
            $user = $pm->load("email", $account->getEmail(), "FUser");
            $acc = $pm->load("email", $account->getEmail(), "FAccount");
            $pren= $pm->VerificaPrenotazione($id, $account->getEmail());
            if (isset($pren)){
                $view->showPrenotazioneErrata($user, $acc, $img, 'no_error');
            }
            else {
                if ($account->getConto() >= 5) {
                    $num=$pm->CountPartecipanti($id);
                    if($num<=10) {
                        $pren_partecipa = $pm->insertPren_partecipa($id, $account->getEmail());
                        $num=$pm->CountPartecipanti($id);
                        $account = EAccount::PagaPartita($account);
                        $conto = $account->getConto();
                        $pm::update('conto', $conto, 'email', $account->getEmail(), "FAccount");
                        $acc = $pm->load('email', $account->getEmail(), "FAccount");
                        $part = $pm->load('idP', $id, "FBooking");

                        $newAcc = $pm->load('email', $account->getEmail(), "FAccount");
                        $salvare = serialize($newAcc);
                        $_SESSION['account'] = $salvare;

                        $view->showPrenotazioneEffettuata($user, $acc, $img, $part, $num);
                    }
                    else{
                        $view->showPrenotazioneErrata($user, $acc, $img, 'no_part');
                    }
                }
                else {
                    $view->showPrenotazioneErrata($user, $acc, $img, 'no_conto');
                }
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le partite per un utenteloggato, con la possibiltà di poter partecipare o creare
     * una partita,se l'utente non risulta loggato viene reindirizzato alla paggina di login
     */
    static function cercaGiorno() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                $view = new VGestionePartite();
                $pm = new FPersistentManager();
                $img = $pm->loadImg($account->getEmail());
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $giorno=self::splitGiorno($_POST['giorno']);
                if(EGiorno::verificaGiorno($giorno)){
                    $partDisp= $pm->loadGiornoDisp($giorno);
                    $view->showFormCreation($user, $acc, $img, $partDisp,  $giorno,'no');
                }
                else {
                    $view->showFormCreation($user, $account, $img,  null, null, "no_giorno");
                }
            }
            else {
                header('Location: /BookAndPlay/User/login');
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le partite per un utenteloggato, con la possibiltà di poter partecipare o creare
     * una partita
     */
    static function partite() {
        if (CUser::isLogged()) {
            $view = new VGestionePartite();
            $pm = new FPersistentManager();
            if ($_SERVER['REQUEST_METHOD'] == "GET"){
                $account = unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    $img = $pm->loadImg($account->getEmail());
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showPartite($user, $acc, $img, null, null);
                }
            }
            elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
                $account = unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    $img = $pm->loadImg($account->getEmail());
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $giorno=self::splitGiorno($_POST['giorno']);
                    $part = $pm->load("giorno", $giorno, "FBooking");
                    for($i=0; $i<count($part); $i++) {
                        $idP[$i] = $part[$i]->getIdbooking();
                        $num[] = $pm->CountPartecipanti($idP[$i]);
                    }
                    $view->showPartite($user, $acc,$img, $part,$num);
                }
            }
            else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le informazioni per una determinata partita che ha selezionato
     */
    static function partita($id) {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            $view = new VGestionePartite();
            $pm = new FPersistentManager();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $part = $pm->load('idP', $id, "FBooking");
                $img = $pm->loadImg($account->getEmail());
                $view->showVaiAllaPartita($user, $acc, $img, $part);
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare un riepilogo delle partite per un utenteloggato
     * se l'utente non è loggato reindirizza alla pagina di login
     */
    static function riepilogo() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                $view = new VGestionePartite();
                $pm = new FPersistentManager();
                $img = $pm->loadImg($account->getEmail());
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $part=$pm->loadRiepilogo($account->getEmail());
                for($i=0; $i<count($part); $i++) {
                    $idP[$i] = $part[$i]->getIdbooking();
                    $num[] = $pm->CountPartecipanti($idP[$i]);
                }
                $view->showRiepilogo($user, $acc, $img, $part, $num); //, $num
            }
            else {
                header('Location: /BookAndPlay/User/login');
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     *Funzione che si occupa di riscrivere il giorno in maniera corretta per eseguire la query sul db, il giorno nel
     * momento in cui viene passato dal $_POST è scritto aaaa/mm/gg mentre quello corretto per eseguire la query è
     * gg/mm/aaaa.
     */
    static function splitGiorno($giorno){
        if ($giorno!=null) {
            $giorno = str_split($giorno, 1);
            $gg = $giorno[8] . $giorno[9] . "/" . $giorno[5] . $giorno[6] . "/" . $giorno[0] . $giorno[1] . $giorno[2] . $giorno[3];
        }
        else{
            $gg=null;
        }
        return $gg;
    }

}
?>

