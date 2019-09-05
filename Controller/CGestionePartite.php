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
     * Funzione che si occupa di mostrare le partite attive anche per un utente non loggato, ma senza la possibilità di
     * poter partecipare con un parametro di ricerca
     * @param
     */
    static function partiteAttive(){
        if(CUser::isLogged()){
            if ($_SERVER['REQUEST_METHOD'] == "GET"){
                $view = new VGestionePartite();
                $view->showPartiteAttive(null,'logged');
            }
            elseif($_SERVER['REQUEST_METHOD'] == "POST"){
                $view = new VGestionePartite();
                $gg= self::splitGiorno($view->getGiorno());

                $pm = new FPersistentManager();
                $partite = $pm->load("giorno", $gg, "FBooking");
                /*for($i=0; $i<count($partite); $i++) {
                    $idP[$i] = $partite[$i]->getIdbooking();
                    $num[] = $pm->CountPartecipanti($idP[$i]);
                }*/
                $view->showPartiteAttive($partite, 'logged');
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }

    }

    /**
     * Funzione che viene richiamata per la creazione di una partita. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono creare partite
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della partita;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione di Creazione().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti viene vializzato l'errore.
     */
    static function creaPartita() {
        if (CUser::isLogged()) {
            $view = new VGestionePartite();
            $pm= new FPersistentManager();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $account = unserialize($_SESSION['account']);
                //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $view->showFormCreation($user, $account, null, null ,'no');
            }
            else {
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $account = unserialize($_SESSION['account']);
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                    $giorno = new EGiorno($_POST['giorno'], $_POST['fascia_oraria']);
                    $gg=$pm->loadGiorno($_POST['giorno'], $_POST['fascia_oraria']);

                    print_r($gg);

                    if (!isset($gg)) {
                        $pm->insertGiorno($giorno);
                        $pren = new EBooking(null, $_POST['livello'], $giorno->getGiorno(), $giorno->getFasceOrarie(), $_POST['descrizione'], null, $account->getEmail());
                        FBooking::store($pren);
                        FPren_partecipa::insert(null, $account->getEmail());
                        $prenotazione=$pm->loadPrenotazioneEff($_POST['giorno'], $_POST['fascia_oraria']);
                        $view->showPrenotazioneEffettuata($user, $acc, $prenotazione); //, $img
                    } else {
                        $view->showFormCreation($user, $account, null, null, "no_giorno");
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
            //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
            $user = $pm->load("email", $account->getEmail(), "FUser");
            $acc = $pm->load("email", $account->getEmail(), "FAccount");
            $pren= $pm->VerificaPrenotazione($id, $account->getEmail());

            if (isset($pren)){

            }
            else {
                if ($account->getConto >= 5) {
                    $pren_partecipa = $pm->insertPren_partecipa($id, $account->getEmail());
                    $account = EAccount::PagaPartita($account);
                    $conto = $account->getConto();
                    $pm::update('conto', $conto, 'email', $account->getEmail(), "FAccount");
                    $acc = $pm->load('email', $account->getEmail(), "FAccount");
                    $part = $pm->load('idP', $id, "FBooking");

                    $view->showPrenotazioneEffettuata($user, $acc, $part);
                }
                else {
                    $view->showPrenotazioneErrata($user, $acc);
                }
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le partite per un utenteloggato, con la possibiltà di poter partecipare o creare
     * una partita
     * @param
     */
    static function cercaGiorno() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                $view = new VGestionePartite();
                $pm = new FPersistentManager();
                //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $giorno=self::splitGiorno($_POST['giorno']);
                $partDisp= $pm->loadGiornoDisp($giorno);

                print_r($partDisp);

                $view->showFormCreation($user, $acc, $partDisp, $giorno,'no');
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che serve per indirizzare ad una form che permette la modifica dei campi della prenotazione .
     * 1) se il metodo di richiesta HTTP è GET e si è loggati, viene visualizzata la form;
     * 2) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la form di login.
     * @param $id id della prenotazione che si vuol modificare
     */
    static function modificaPrenotazione($giorno)
    {
        $pm = new FPersistentManager();
        $view = new VGestionePartite();
        if( CUtente::isLogged() && ($_SERVER['REQUEST_METHOD'] == "GET")) {
            $account = unserialize($_SESSION['account']);
            if ($account->getEmail() == "admin@admin.com") {
                $prenotazione = $pm::load("giorno", $giorno, "FGiorno");
                $view->showPartite($giorno);
            }
            else
                header('Location: /BookAndPlay/');
        }
        else header('Location: /BookAndPlay/User/login');
    }

    /**
     * Funzione che viene invocata nel momento in cui si modificano i valori della prenotazione
     * 1) se il metodo di richiesta HTTP è POST e si è loggati come amministratore si applicano le modifiche all'annuncio;
     * 2) se il metodo di richiesta HTTP è GET e non si è loggati come amministratore avviene il reindirizzamento alla pagina del prorpio profilo;
     * 3) se non si è loggati, si viene reindirizzati alla form di login.
     */
    static function applicaModifiche() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if ($account->getEmail() == "admin@admin.com"){
                    $view = new VGestionePartite();
                    $pm = new FPersistentManager();
                    $Profilo = new VUser();
                    //$giorno = $view->getGiorno();
                    $oldFascia= $view->getOldFasciaOraria();
                    $newFascia= $view->getNewFasciaOraria();
                    $giorno = $_POST['giorno'];
                    $pm->update("disp", "disponibile", "Fascia", $oldFascia, "FGiorno");
                    $pm->update("disp", "non disponibile", "Fascia",$newFascia, "FGiorno");
                    $account = unserialize($_SESSION['account']);
                    $img = FMediaUser::loadByIdAcc($account);
                    $user=FUser::loadByIdAccount($account);
                    $Profilo->showProfiloUser($user, $account, $img);
            } else {
                header('Location: /BookAndPlay/User/profile');
            }
        }
        else
            header('Location: /BookAndPlay/User/login');
    }

    /**
     * Funzione che si occupa di mostrare le partite per un utenteloggato, con la possibiltà di poter partecipare o creare
     * una partita
     * @param
     */
    static function partite() {
        if (CUser::isLogged()) {
            $view = new VGestionePartite();
            $pm = new FPersistentManager();
            if ($_SERVER['REQUEST_METHOD'] == "GET"){
                $account = unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $view->showPartite($user, $acc, null);
                }
            }
            elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
                $account = unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $giorno=self::splitGiorno($_POST['giorno']);
                    $part = $pm->load("giorno", $giorno, "FBooking");
                    $view->showPartite($user, $acc,$part);
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

                $view->showVaiAllaPartita($user, $acc, $part);

            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le partite per un utenteloggato, con la possibiltà di poter partecipare o creare
     * una partita
     * @param
     */
    static function riepilogo() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                $view = new VGestionePartite();
                $pm = new FPersistentManager();
                //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $part=$pm->loadRiepilogo($account->getEmail());

                $view->showRiepilogo($user, $acc, $part); //, $num
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     *Funzione che si occupa di riscrivere il giorno in maniera corretta per eseguire la query sul db, il giorno nel
     * momento in cui viene passato dal $_POST è scritto aaaa/mm/gg mentre quello corretto per eseguire la query è
     * gg/mm/aaaa.
     */
    static function splitGiorno($giorno){
        $giorno=str_split($giorno,1);
        $gg=$giorno[8].$giorno[9]."/".$giorno[5].$giorno[6]."/".$giorno[0].$giorno[1].$giorno[2].$giorno[3];
        return $gg;
    }

}
?>

