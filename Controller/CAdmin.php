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
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
            } else
                header('Location: /BookAndPlay/User/login');
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

                print "okBAN";
                print_r($email);
                print_r($_POST['email']);

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
	 * Funzione utile per eliminare una prenotazione.
	 * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenenti le partite;
	 * 2) se il metodo di richiesta HTTP è POST (loggati come amminstratore), può essere eliminata una prenotazione;
	 * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
	 * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
	 * @param $id
	 * @throws SmartyException
	 */
	static function eliminaPrenotazione($id){
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			$pm = new FPersistentManager();
			$pm->delete("id", $id, "FBooking");
			header('Location: /BookAndPlay/Admin/partite');
		}
		elseif($_SERVER['REQUEST_METHOD'] == "GET") {
			if (CUser::isLogged()) {
				$account = unserialize($_SESSION['account']);
				if ($account->getEmail() == "admin@admin.com") {
					header('Location: /BookAndPlay/Admin/partite');
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
     * Funzione utilizzata per aggiornare il conto di un Utente
     * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata
     * la pagina dove inserire l'username dell'utente al quale bisogna aggiungere una certa cifra di conto;
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) altrimenti, reindirizza alla pagina di login.
     */
    static function ricaricaConto($username, float $conto){
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUser::isLogged()) {
                $account = unserialize($_SESSION['account']);
                if ($account->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $email= $view->getEmail();
                    $pm = new FPersistentManager();
                    $acc=FAccount::loadByUsername($username);
                    $acc= new EAccount($acc);
                    $conto=$acc->RicaricaAccount($conto);
                    $pm->update("conto", $conto, "email", $email, "FAccount");

                    header('Location: /BookAndPlay/Admin/ricaricaConto');

                    //$view->showConto();
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

}