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
                $view->showFormCreation($user, $account, null, 'no');
            }
            elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $pm = new FPersistentManager();
                $account = unserialize($_SESSION['account']);
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $giorno= new EGiorno($_POST['giorno'], $_POST['fasce_orarie']);
                $gg=$pm->loadGiorno($_POST['giorno'], $_POST['fasce_orarie']);

                if (!isset($gg)) {
                    $pren= new EBooking(null,$_POST['livello'],$giorno->getGiorno(),$giorno->getFasceOrarie(),$_POST['descrizione'],null);
                    FPren_partecipa::insert(null, $account->getEmail());
                    FBooking::store($pren);

                    $view->showPrenotazioneEffettuata($user, $acc, $pren); //, $img
                }
                else {
                    $view->showFormCreation($user, $account, "no_giorno");
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
                $part = $pm->load("giorno", $_POST['giorno'], "FGiorno");
                $view->showFormCreation($user, $acc, $part,'no');
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
    }

/*
    /**
     * Funzione che provvede alla creazione della campagna a partire dai dati inseriti nel form. Si possono avere diversi casi:
     * - se il form compilato dall'utente è corretto (viene verificato tramite il richiamo della funzione valFormCreaCampagna())
     *   si procede alla creazione della campagna i cui dati vengono quindi memorizzati nel database.
     * - se il form compilato non è corretto viene mostrato nuovamente con la segnalazione degli errori.
     */
 /*   static function CreationPartita(){
        if (CUser::isLogged()) {
             $view = new VGestionePartite();
                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    $account = unserialize($_SESSION['account']);
                    $user=FUser::loadByIdAccount($account);
                    $img=FMediaUser::loadByIdAccount($account);
                    $val=true;
                    if($val){
                        $pren= new EBooking(" ",$_POST[''],$_POST[''],$_POST[''],$_POST[''],$_POST['']);
                        $idPren=FBooking::store($pren);
                        $up=new Upload();

                        $view->showPrenotazioneEffettuata($user, $account, $idPren, $img);
        }
        else{
            header('Location: /BookAndPlay/Utente/login');
        }
    }
*/

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
     * Funzione che si occupa di eliminare una prenotazione soltanto se l'utente è loggato ed è Admin
     * se l'utente non è admin mostra il profilo
     * se l'utente non è loggato mostra la schermata di login
     * @param $id id dell'annuncio da eliminare
     */
    static function deleteannuncio($id) {
        if (CUser::isLogged()) {
            $account= unserialize($_SESSION['account']);
            if ($account->getEmail() == "admin@admin.com"){
                    $pm = new FPersistentManager();
                    $pm->delete("idPren", $id, "FBooking");
            } else {
                header('Location: /BookAndPlay/User/profile');
            }
        }
        else
            header('Location: /BookAndPlay/User/login');
    }

    /**
     * Funzione che si occupa di mostrare le partite attive anche per un utente non loggato, ma senza la possibilità di
     * poter partecipare
     * @param
     */
    static function partiteAttive(){
        $view = new VGestionePartite();
        $view->showPartiteAttive();
    }

    /**
     * Funzione che si occupa di mostrare le partite per un utenteloggato, con la possibiltà di poter partecipare o creare
     * una partita
     * @param
     */
    static function partite() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                $view = new VGestionePartite();
                $pm = new FPersistentManager();
                //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $view->showPartite($user, $acc);
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
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
                $view->showRiepilogo($user, $acc);
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
    }


    /**
     * Funzione che si occupa di mostrare le partite attive anche per un utente non loggato, ma senza la possibilità di
     * poter partecipare con un parametro di ricerca
     * @param
     */
    static function partiteAttiveGiorno(){
        $view = new VGestionePartite();
        $giorno=$_POST['giorno'];

        print($giorno);

        $pm = new FPersistentManager();
        $partite = $pm->load("giorno", $giorno, "FBooking");
        $view->CercaPartiteAttive($partite);
    }


}
?>

