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
            $view = new VGestionePartite();
            $view->showPartiteAttive(null,'nouser');
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
                $view->showPrenotazioneErrata($user, $acc, $img, 'delete');
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
                    $giorno = new EGiorno($_POST['giorno'], $_POST['fascia_oraria']);
                    $gg=$pm->loadGiorno($_POST['giorno'], $_POST['fascia_oraria']);

                    if (!isset($gg)) {
                        $pm->insertGiorno($giorno);
                        $pren = new EBooking(null, $_POST['livello'], $giorno->getGiorno(), $giorno->getFasceOrarie(), $_POST['descrizione'], null, $account->getEmail());
                        $id=FBooking::store($pren);
                        FPren_partecipa::insert($id, $account->getEmail());
                        $account = EAccount::PagaPartita($account);
                        $conto = $account->getConto();
                        $pm::update('conto', $conto, 'email', $account->getEmail(), "FAccount");
                        $acc = $pm->load('email', $account->getEmail(), "FAccount");
                        $img = $pm->loadImg($account->getEmail());
                        $prenotazione=$pm->loadPrenotazioneEff($_POST['giorno'], $_POST['fascia_oraria']);

                        $newAcc = $pm->load('email',$account->getEmail(), "FAccount");
                        $salvare = serialize($newAcc);
                        $_SESSION['account'] = $salvare;

                        $view->showPrenotazioneEffettuata($user, $acc, $img, $prenotazione); //
                    } else {
                        $view->showFormCreation($user, $account, $img,  null, null, "no_giorno");
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
                $view->showPrenotazioneErrata($user, $acc, $img);
            }
            else {
                if ($account->getConto() >= 5) {
                    $pren_partecipa = $pm->insertPren_partecipa($id, $account->getEmail());
                    $account = EAccount::PagaPartita($account);
                    $conto = $account->getConto();
                    $pm::update('conto', $conto, 'email', $account->getEmail(), "FAccount");
                    $acc = $pm->load('email', $account->getEmail(), "FAccount");
                    $part = $pm->load('idP', $id, "FBooking");

                    $newAcc = $pm->load('email',$account->getEmail(), "FAccount");
                    $salvare = serialize($newAcc);
                    $_SESSION['account'] = $salvare;

                    $view->showPrenotazioneEffettuata($user, $acc, $img, $part);
                }
                else {
                    $view->showPrenotazioneErrata($user, $acc, $img);
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
                $img = $pm->loadImg($account->getEmail());
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $giorno=self::splitGiorno($_POST['giorno']);
                $partDisp= $pm->loadGiornoDisp($giorno);

                print_r($partDisp);

                $view->showFormCreation($user, $acc, $img, $partDisp,  $giorno,'no');
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
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
                    $img = $pm->loadImg($account->getEmail());
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showPartite($user, $acc, $img, null);
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
                    $view->showPartite($user, $acc,$img, $part);
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
                $img = $pm->loadImg($account->getEmail());
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $part=$pm->loadRiepilogo($account->getEmail());

                $view->showRiepilogo($user, $acc, $img, $part); //, $num
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

