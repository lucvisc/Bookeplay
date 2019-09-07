<?php
/**
 * La classe CAdmin implementa funzionalità per l'admin, al quale sarà consentito di bloccare e sbloccare gli utenti
 * eliminare, modificare e creare le prenotazioni
 * @author Luca, Catriel
 * @package Controller
 */

//require_once 'include.php';
class CAdmin{
    /**
     * Funzione utilizzata per visualizzare la pagina dell'amministratore, nella quale sono presenti tutti gli utenti della piattaforma.
	 * Gli utenti sono divisi in due liste: bannati e attivi.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata la homepage con l'elenco di tutti gli utenti;
	 * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
	 * 3) altrimenti, reindirizza alla pagina di login.
     */
	static function homepage () {
        if (CUser::isLogged()) {
            $view = new VAdmin();
            $pm = new FPersistentManager();

            $utentiAttivi = $pm->loadAccount(1);
            $utentiBannati = $pm->loadAccount(0);
            $n_attivi = count($utentiAttivi) - 1;

            if(isset($utentiBannati)) {
                $n_bannati = count($utentiBannati);
                if ($n_bannati > 0) {
                    $n_bannati = count($utentiBannati) - 1;
                }
                else $n_bannati = 0;
            }
            else $n_bannati = 0;

            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $account = unserialize($_SESSION['account']);
                if ($account->getEmail() == "admin@admin.com") {

                    $view->showUtenti($utentiAttivi, $utentiBannati, $n_attivi, $n_bannati, null, null);
                }
            }
            elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $account = unserialize($_SESSION['account']);
                if ($account->getEmail() == "admin@admin.com") {
                    $acc = $pm->load("email", $_POST['email'], "FAccount");

                    if (isset($acc)) {
                        if ($acc->getActivate() == 1) {
                            $view->showUtenti($utentiAttivi, $utentiBannati, $n_attivi, $n_bannati, $acc, null);
                        } else {
                            $view->showUtenti($utentiAttivi, $utentiBannati, $n_attivi, $n_bannati, null, $acc);
                        }

                    } else {
                        $view->showUtenti($utentiAttivi, $utentiBannati, $n_attivi, $n_bannati, null, $acc);
                    }
                } else {
                    $view = new VError();
                    $view->error('1');
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
	 * Funzione utile per cambiare lo stato di un utente
	 * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, si visualizza la home dell'amministratore;
	 * 2) se il metodo di richiesta HTTP è POST loggati come amministratore avviene l'azione vera e propria di bannare l'utente
	 * 	  cambiando il suo stato in false
	 * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
	 * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente compare una pagina di errore 401.
	 */
	static function bannaUtente(){
        if (CUser::isLogged()) {
		    if($_SERVER['REQUEST_METHOD'] == "POST") {
                $view = new VAdmin();
                $pm = new FPersistentManager();
                $email = $view->getEmail();

                $account = $pm->load("email", $email, "FAccount");
                print_r($account);
                $pm->update("activate", 0, "email", $email, "FAccount");
                print_r($pm);

                header('Location: /BookAndPlay/Admin/homepage');
		}
		elseif($_SERVER['REQUEST_METHOD'] == "GET") {
		        $account = unserialize($_SESSION['account']);
				if ($account->getEmail() == "admin@admin.com") {

				    print "okNON ENtra";

					header('Location: /BookAndPlay/Admin/homepage');
				}
				else {
					$view = new VError();
					$view->error('1');
				}
			}
		}
        else
            header('Location: /BookAndPlay/User/login');
    }

	/**
	 * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a true).
	 * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore si visualizza la home dell'amministratore;
	 * 2) se il metodo di richiesta HTTP è POST loggati come amministratore si puà riattivare l'utente cambiando il suo stato in true
	 * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
	 * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente compare una pagina di errore 401.
	 */
	static function attivaUtente(){
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			$view = new VAdmin();
			$pm = new FPersistentManager();
			$email = $view->getEmail();
			$pm->update("activate", 1, "email", $email, "FAccount");
			header('Location: /BookAndPlay/Admin/homepage');
		}
		elseif($_SERVER['REQUEST_METHOD'] == "GET") {
			if (CUser::isLogged()) {
				$account = unserialize($_SESSION['account']);
				if ($account->getEmail() == "admin@admin.com") {
					header('Location: /BookAndPlay/Admin/homepage');
				}
				else {
					$view = new VError();
					$view->error('1');
				}
			}
			else
				header('Location: /BookAndPlay/User/login');
		}
    }

    /**
     * Funzione che si occupa di mostrare le partite per l'admin con la possibilità di creare o cancellare una partita
     */
    static function partite(){
        if (CUser::isLogged()) {
            $view = new VAdmin();
            $pm = new FPersistentManager();
            $account = unserialize($_SESSION['account']);
            if ($account->getEmail() == "admin@admin.com") {
                $view->showCreaCancella(null, null);
            } else {
                $view = new VError();
                $view->error('1');
            }
        }
        else{
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di creare una partita
     */
    static function creaPartita(){
        if(CUser::isLogged()){
            $account=unserialize($_SESSION['account']);
            $pm=new FPersistentManager();
            $view= new VAdmin();
            if ($account->getEmail()=='admin@admin.com'){
                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    $view->showCrea(null,null, 'si_giorno');
                }
                elseif($_SERVER['REQUEST_METHOD']=="POST"){
                    $giorno = new EGiorno($_POST['giorno'], $_POST['fascia_oraria']);
                    $gg=$pm->loadGiorno($_POST['giorno'], $_POST['fascia_oraria']);

                    if (!isset($gg)) {
                        $pm->insertGiorno($giorno);
                        $pren = new EBooking(null, $_POST['livello'], $giorno->getGiorno(), $giorno->getFasceOrarie(), $_POST['descrizione'], null, $account->getEmail());
                        $id=FBooking::store($pren);
                        $prenotazione=$pm->loadPrenotazioneEff($_POST['giorno'], $_POST['fascia_oraria']);

                        print_r($prenotazione);

                        $view->showPrenotazione($prenotazione);
                    } else {
                        $view->showCrea( null, null, "no_giorno");
                    }

                }
            }
            else {
                $view = new VError();
                $view->error('1');
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le partite per l'admin per un determinato giorno
     * una partita
     * @param
     */
    static function cercaGiorno() {
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if ($account->getEmail()== 'admin@admin.com') {
                $view = new VAdmin();
                $pm = new FPersistentManager();

                $giorno=self::splitGiorno($_POST['giorno']);
                $partDisp= $pm->loadGiornoDisp($giorno);

                $view->showCrea($partDisp, $giorno, 'sigiorno');
            } else {
                header('Location: /BookAndPlay/User/login');
            }
        } else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che si occupa di mostrare le partite per l'admin per un determinato giorno
     * una partita
     * @param
     */
    static function cercaPartita() {
        if (CUser::isLogged()) {
                $view = new VAdmin();
                $pm = new FPersistentManager();
                $giorno=self::splitGiorno($view->getGiorno());
                $part= $pm->load('Giorno', $giorno,"FBooking");

                print_r($part);

                $view->showCreaCancella($part, true);
            }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**
     * Funzione che visualizza una specifica prenotazione per poter essere semplicemente visualizzata oppure eliminata
     * con l'accesso come amministratore
     * Se il metodo di richiesta HTTP è GET, l'admin sta chiedendo di vedere più informazioni riguardanti la partita presa in considerazione
     * Se il metodo di richiesta HTTP è POST, l'admin sta eliminando la prenotazione cliccando sull'apposito bottone
     * Se si prova ad accedere con un utente loggato (e non con l'admin) ti reindirizza all'errore 401
     * Se si prova ad accedere con un utente non loggato, reindirizza alla pagina di login
     */
    static function partita($id){
        if (CUser::isLogged()){
            $view= new VAdmin();
            $pm = new FPersistentManager();
            $account=unserialize($_SESSION['account']);
            if ($account->getEmail() == 'admin@admin.com') {
                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    $partita = $pm->load('idP', $id, "FBooking");
                    $view->showCreaCancella($partita, null);
                }
                elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $pm->delete('idP',$id,"FBooking");
                    $view->showCreaCancella(null, null);
                }
            }
            else {
                    $view = new VError();
                    $view->error('1');
            }
        }
        else {
            header('Location: /BookAndPlay/User/login');
        }
    }

    /**Funzione che permette di modificare una determinata prenotazione
     * @throws SmartyException
     */
    static function modifica($id){
	    if(CUser::isLogged()){
	        $pm= new FPersistentManager();
	        $view= new VAdmin();
	        $account= unserialize($_SESSION['account']);
            $partita = $pm->load('idP', $id, "FBooking");
            $giorno= $partita[0]->getGiornobooking()->getGiorno();
            $email = $partita[0]->getOrganizzatore();
	        if ($account->getEmail()== 'admin@admin.com'){
	            if ($_SERVER['REQUEST_METHOD'] == "GET"){
                    $partDisp= $pm->loadGiornoDisp($giorno);
	                $view->showModificaPartita($partita, $giorno, $partDisp, 'no_error');
                }
	            elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (!isset($_POST['new_giorno'])) {
                        if (isset($_POST['new_fascia_oraria'])) {
                            $prenotazione = $pm->loadPrenotazioneEff($giorno, $_POST['new_fascia_oraria']);
                            if (!isset($prenotazione)) {
                                $pm::update('FasciaOraria', $_POST['new_fascia_oraria'], 'idP', $id, "FBooking");
                                $partita = $pm->load('idP', $id, "FBooking");
                                $view->showPrenotazione($partita);
                            } else {
                                $view->showModificaPartita(null, null, null, 'no_error');
                            }
                        } else {
                            $view->showModificaPartita(null, null, null, 'no_error');
                        }
                    } else {
                        $newGiorno=self::splitGiorno($_POST['new_giorno']);
                        $prenotazione = $pm->loadPrenotazioneEff($newGiorno, $_POST['new_fascia_oraria']);
                        if (!isset($prenotazione)) {
                            $pm::update('giorno', $newGiorno, 'idP', $id, "FBooking");
                            $pm::update('FasciaOraria', $_POST['new_fascia_oraria'], 'idP', $id, "FBooking");
                            $partita = $pm->load('idP', $id, "FBooking");

                            $view->showPrenotazione($partita);
                        } else {
                            $view->showModificaPartita(null, null, null, 'no_error');
                        }
                    }
                }
	        }
	        else{
                $view = new VError();
                $view->error('1');
            }
        }
	    else {
            header('Location: /BookAndPlay/User/login');
        }
    }

	/**
	 * Funzione utilizzata per visualizzare l'elenco delle partite.
	 * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata
     * la pagina con l'elenco di tutte le prenotazioni;
	 * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
	 * 3) altrimenti, reindirizza alla pagina di login.
	 */
	static function prenotazioniGiorno($giorno){
		if($_SERVER['REQUEST_METHOD'] == "GET") {
			if (CUser::isLogged()) {
				$account = unserialize($_SESSION['account']);
				if ($account->getEmail() == "admin@admin.com") {
					$view = new VAdmin();
					$pm = new FPersistentManager();
					//$prenotazioni = $pm->load("id", 1, "FBooking");
					$gg=FGiorno::loadGiorni($giorno);
					$utentiAttivi = null;

					$view->showPartite($gg);
				}
				else {
					$view = new VError();
					$view->error('1');
				}
			}
			else
				header('Location: /BookAndPlay/User/login');
		}
	}

    /**
     * Funzione utilizzata per aggiornare il conto di un User
     * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata
     * la pagina dove inserire l'email al quale applicare l'aggiunta del conto
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) se il metodo di richiesta HTTP è POST e si è loggati come amministratore avviene la ricarica del conto
     * 4)se non si è loggati reindirizza alla pagina di login.
     */
    static function ricaricaConto(){
        if (CUser::isLogged()) {
            $pm= new FPersistentManager();
            $view= new VAdmin();
            $account = unserialize($_SESSION['account']);
            if ($account->getEmail() == "admin@admin.com") {
                    if($_SERVER['REQUEST_METHOD'] == "GET") {
                        $view->showRicaricaConto(null);
                    }
                    elseif($_SERVER['REQUEST_METHOD'] == "POST") {
                        if(!isset($_POST['cifra'])){
                            $acc = $pm->load("email", $_POST['email'], "FAccount");

                            $view->showRicaricaConto($acc);
                        }
                        else {

                            $email = $view->getEmail();
                            $account = $pm->load('email', $email, "FAccount");
                            $cifra = $view->getCifra();
                            $account->RicaricaAccount($cifra);
                            $conto = $account->getConto();
                            $pm->update('conto', $conto, 'email', $email, "FAccount");
                            $account = $pm->load('email', $email, "FAccount");

                            $view->showRicaricaConto($account);
                        }

                    }
            }
            else {
                $view = new VError();
                $view->error('1');
            }
        }
        else{
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