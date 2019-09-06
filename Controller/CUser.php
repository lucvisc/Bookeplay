<?php

/**
 * Class CUser si occupa di gestire la visualizzazione delle form e adattarle al template, gestire il collegamento tra
 * view-template e classi Entity e Foundation
 * @Gruppo Luca, Catriel
 * @package Controller
 */

require_once 'include.php';

class CUser {

	/**
	 * Funzione che consente il login di un utente registrato. Si possono avere diversi casi:
	 * 1) se il metodo della richiesta HTTP è GET:
	 *   - se l'utente è già loggato viene reindirizzato alla homepage;
	 * 	 - se l'utente non è loggato si viene indirizzati alla form di login;
	 * 2) se il metodo della richiesta HTTP è POST viene richiamata la funzione verifica().
	 */
    static function login (){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            if(static::isLogged()) {
                $account= unserialize($_SESSION['account']);
                if($account->getEmail()!= 'admin@admin.com') {
                    $view = new VUser();
                    header('Location: /BookAndPlay/User/profiloUtente');
                }
                else {
                    header('Location: /BookAndPlay/Admin/homepage');
                }
            }
            else{
                $view=new VUser();
                $view->showFormLogin();
            }
        }elseif ($_SERVER['REQUEST_METHOD']=="POST")
            static::verifica();
    }

    /**
     * Funzione che si occupa di verifica l'esistenza di un utente con username e password inseriti nel form di login.
     * 1) se, dopo la ricerca nel db non si hanno risultati ($utente = null) oppure se l'utente si trova nel db ma ha lo stato false
     *    viene ricaricata la pagina con l'aggunta dell'errore nel login.
     * 2) se l'utente ed è attivo, avviene il reindirizzamaneto alla homepage degli annunci;
     * 3) se le credenziali inserite rispettano i vincoli per l'amministratore, avviene il reindirizamento alla homepage dell'amministratore;
     * 4) se si verifica la presenza di particolari cookie avviene il reindirizzamento alla pagina specifica.
     */

    static function verifica() {
        $view = new VUser();
        $pm = new FPersistentManager();
        $account = $pm->loadLogin($_POST['email'], $_POST['password']);

        if ($account != null && $account->getActivate() != 0 ){ //&& $account->getActivate() != false

            if (session_status() == PHP_SESSION_NONE) {
                session_set_cookie_params('3600'); // 1 ora dal login
                session_start();
                $salvare = serialize($account);
                $_SESSION['account'] = $salvare;

                print($_SESSION['account']);

                if ($_POST['email'] != 'admin@admin.com') {
                    if (isset($_COOKIE['nome_visitato'])) {
                        header('Location: /BookAndPlay/User/profiloUtente');
                        //$view->showProfile();
                    }
                    else {
                        header('Location: /BookAndPlay/User/profiloUtente');
                        //CUser::profile();
                    }
                }
                else {
                    header('Location: /BookAndPlay/Admin/homepage');
                }
            }
        }
        else {
            $view->loginError();
        }
    }


	/**
	 * Funzione che provvede alla rimozione delle variabili di sessione, alla sua distruzione e a rinviare alla homepage
	 */
	static function logout(){
     //   session_name('BookAndPlay');
		session_start();
		session_unset();
		session_destroy();
		header('Location: /BookAndPlay/');
	}

    /**
     * Mostra la pagina iniziale dell'applicazione
     */
    static function showHomepage() {
        $view = new VUser();
        $view->Homepage();
    }

	/**
	 * Metodo che verifica se l'utente è loggato
	 */
	static function isLogged() {
		$identificato = false;
		if (isset($_COOKIE['PHPSESSID'])) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
		}
		if (isset($_SESSION['account'])) {
			$identificato = true;
		}
		return $identificato;
	}

	public function error() {
    	$view = new VError();
    	$view->error('1');
	}

    /** Metodo che mostra il profilo dell'utente loggato o il profilo di un altro utente a seconda del tipo di URL:
     *
     */
    static function profiloUtente() {
        $view = new VUser();
        $pm = new FPersistentManager();
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                if($account->getEmail() != 'admin@admin.com'){
                    //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $addr = $pm->load("email", $account->getEmail(), "FAddress");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showProfileUser($user, $acc, $addr);
                }
                else {
                    header('Location: /BookAndPlay/Admin/homepage');
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


    /** Metodo che mostra il profilo dell'utente loggato o il profilo di un altro utente a seconda del tipo di URL:
     *
     */
    static function profilo() {
        $view = new VUser();
        $pm = new FPersistentManager();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUser::isLogged())
                $account= unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    $img = $pm->load("emailUtente", $account->getEmail(), "FMediaUser");
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $addr= $pm->load("email", $account->getEmail(), "FAddress");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showProfile($user, $acc, $addr, $img);
                } else {
                    header('Location: /BookAndPlay/User/login');
                }
            }
        else {
                header('Location: /BookAndPlay/User/login');
        }
    }

	/**
	 * Funzione che si occupa di mostrare la form di registrazione per un utente
	 * 1) se il metodo della richiesta HTTP è GET e si è loggati, avviene il reindirizzamento alla homepage;
	 * 2) se il metodo della richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento vero e proprio alla form di registrazione;
	 * 3) se il metodo della richiesta HTTP è POST viene invocato il metodo registra_cliente() che si occupa della gestione dei dati inseriti nella form.
	 */
	static function registrazioneUtente(){
		if($_SERVER['REQUEST_METHOD']=="GET") {
			$view = new VUser();
			if (static::isLogged()) {
                $account = unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    $pm = new FPersistentManager();
                    //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $addr = $pm->load("email", $account->getEmail(), "FAddress");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showProfileUser($user, $acc, $addr);
                }
            }
			else {
				$view->showFormRegistration();
			}
		}else if($_SERVER['REQUEST_METHOD']=="POST") {
			static::VerificaRegistrazioneUser();
		}
	}

	/**
	 * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
	 * In questo metodo avviene la verifica sull'univocità dell'email inserita;
	 * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
	 */
	static function VerificaRegistrazioneUser() {
		$pm = new FPersistentManager();
		$view = new VUser();
		$veremail = $pm->exist("email", $_POST['email'],"FAccount");
		if ($veremail){
			$view->registrationError("email");
		}
		elseif ($_POST['password'] == $_POST['password1']){
			$account = new EAccount($_POST['email'], $_POST['username'], $_POST['password'],$_POST['telnumber'], 0, " ", 1);
			$addr = new EAddress(" ", $_POST['comune'], $_POST['provincia'], $_POST['cap'], $_POST['via'], $_POST['numero']);
			$user = new EUser(" ", $_POST['name'], $_POST['surname'], $_POST['data_nascita'], $_POST['gender'], 'registrato');

			print_r($account);
			print_r($addr);
			print_r($user);
            //$pm::storeReg($account,$user, $addr);
            FAccount::store($account,$user, $addr);

            if ($account!= null) {
				if (isset($_FILES['file'])) {
					$nome_file = 'file';
					$img = static::upload($account,"showFormRegistration",$nome_file);
					switch ($img) {
						case "size":
							$view->registrationError("size");
							break;
						case "type":
							$view->registrationError("typeimg");
							break;
						case "ok":
							header('Location: /BookAndPlay/User/login');
							break;
					}
				}
			}
            $view->showFormLogin();

		}
		else {
            $view->registrationError("password");
        }
	}

    /**
     * Funzione che ha il compito di richiamare una nuova vista a partire da quella del profilo privato che permette la
     * modifica di tutti i campi riguardanti un utente. Anche in questo caso, avviene la differenziazione tra i due tipi di utenti.
     * 1) se il metodo della richiesta HTTP è GET e si è loggati, viene presentata la nuova vista per modificare i propri dati;
     * 2) se il metodo della richiesta HTTP è GET ma non si è loggati, allora avviene il reindirizzamento verso la form di login;
     * 3) se il metodo della richiesta HTTP è POST, vengono rilevati tutti i valori inseriti dall'utente per la modifica e dopo aver controllato
     * 	  l'univocità dell'email (nel caso in cui venisse cambiata), la correttezza della password inserita e, se si è
     *    trasportatore, l'univocità della nuova targa, si procede con l'update dei campi nel database per poi essere reindirizzati alla pagina del priprio profilo.
     */
    public function modificaProfilo() {
        $pm = new FPersistentManager();
        $view = new VUser();
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUser::isLogged()) {
                $account = unserialize($_SESSION['account']);
                //$img = $pm->load("emailUser", $account->getEmail(), "FMediaUser");
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $addr = $pm->load("email", $account->getEmail(), "FAddress");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $view->showModificaProfilo($user, $acc,"ok"); // $img,

            } else
                header('Location: /BookAndPlay/User/login');
        }
        elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $account = unserialize($_SESSION['account']);  //Creates a PHP value from a stored representation
            $pm = new FPersistentManager();
            //$img = $pm->load("emailutente", $account->getEmail(), "FMediaUser");
            if (get_class($account) == "EAccount") {
                if ($account->getPassword() == $_POST['old_password']) {
                    if ($account->getEmail() == $_POST['email']) {
                        //$statoimg = static::modificaprofiloimmagine($account);
                        //if ($statoimg) {
                            static::updateCampi($account, "FAccount", $_POST['username'], $_POST['new_password']);
                            $newAcc =FAccount::loadByField('email',$account->getEmail());
                            $salvare = serialize($newAcc);
                            $_SESSION['account'] = $salvare;
                            header('Location: /BookAndPlay/User/profilo');
                        //}
                    }
                    else {
                        $verificaEmail = $pm->exist("email", $_POST['email'], "FAccount");
                        if ($verificaEmail) {
                            //UTENTE GIA NEL DB
                            $user = $pm->load("email", $account->getEmail(), "FUser");
                            $view->showModificaProfilo($user, $account, "errorEmail"); // $img,
                        }
                        else {
                            //$statoimg = static::modificaprofiloimmagine($account);
                            //if ($statoimg) {
                                static::updateCampi($account, "FAccount", $_POST['username'], $_POST['new_password']);
                                $pm->update("email", $_POST['email'], "email", $account->getEmail(), "FAccount");
                                $newAcc=$pm->load("email", $account->getEmail(), "FAccount");
                                //$img =$pm->load("email", $account->getEmail(), "FMediaUser");
                                $user = $pm->load("email", $account->getEmail(), "FUser");
                                $addr = $pm->load("email", $account->getEmail(), "FAddress");

                                $salvare = serialize($newAcc);
                                $_SESSION['account'] = $salvare;
                                $view->showProfileUser($user, $newAcc, $addr); //,$img
                            //}
                        }
                    }
                } else {
                    //ERRORE PASSWORD
                    $newAcc=$pm->load("email", $account->getEmail(), "FAccount");
                    //$img =$pm->load("email", $account->getEmail(), "FMediaUser");
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $addr = $pm->load("email", $account->getEmail(), "FAddress");
                    $view->showModificaProfilo($user, $newAcc, 'errorPassw'); //, $img
                }

            }
            else {
                header('Location: /BookAndPlay/User/login');
            }
        }
    }

    /**
     * Funzione che si occupa di fare tutti i controlli necessari per aggiornare i campi che un utente desidera modificare
     * nella sua form di modifica profilo, viene utilizzata dalla function modificaprofilo
     * @param $account obj rappresentante l'account di un user
     * @param $class classe del account che richiede le modifiche
     */
    static private function updateCampi($account,$class, $username, $pass) {
        $pm = new FPersistentManager();
        if ($account->getUsername() != $username)
            $pm->update("username", $username, "email", $account->getEmail(), $class);
        if ($_POST['new_password'] != "")
            $pm->update("password", $pass, "email", $account->getEmail(), $class);
    }

	/**
	 * Funzione di supporto che si occupa di verificare la correttezza dell'immagine inserita nella form di registrazione.
	 * Nll caso in cui non ci sono errori di inserimento, avviene la store dell'utente e la corrispondente immagine nel database.
	 * @param $utente obj utente
	 * @param $funz tipo di funzione da svolgere
	 * @param $nome_file passato nella form per l'immagine
	 * @return string stato verifa immagine
	 */
	static function upload($account,$funz,$nome_file) {
		$pm = new FPersistentManager();
		$ris = null;
		$nome = '';
		$max_size = 300000;
		$result = is_uploaded_file($_FILES[$nome_file]['tmp_name']);
		if (!$result) {
			//no immagine
			if ($funz == "showFormRegistration") {
				$pm->store($account);
				$ris = "ok";
			}
		} else {
			$size = $_FILES[$nome_file]['size'];
			$type = $_FILES[$nome_file]['type'];
			if ($size > $max_size) {
				//Il file è troppo grande
				$ris = "size";
			}
			elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
				$nome = $_FILES[$nome_file]['name'];
				if ($funz == "showFormRegistration") {
                    $pm = new FPersistentManager();
					$pm->store($account);
					$mediaUtente = new EMediaUser($nome, $account->getEmail());
					$mediaUtente->setType($type);
					$pm->storeMedia($mediaUtente,$nome_file);
					$ris = "ok";
				}
				elseif ($funz == "modificaUser") {
					$pm->delete("emailutente",$account->getEmail(),"FMediauser");
					$mediaUtente = new EMediaUser($nome, $account->getEmail());
					$mediaUtente->setType($type);
					$pm->storeMedia($mediaUtente,$nome_file);
					$ris = "ok";
				}
			}
			else {
				//formato diverso
				$ris = "type";
			}
		}
		return $ris;
	}

	/**
	 * Funzione di supporto per le altre. Questa funzione, grazie alla chiamata della funzione upload(), si occupa di gestire
	 * il comportamento della form rispetto all'inserimento delle immagini dando la possibilità di notificare errori relativi al
	 * tipo di immagine o la dimensione. Ancora una volta avviene la differenziazione tra Cliente e Trasportatore dove nel secondo caso,
	 * grazie alla funzione upload_mesia_mezzo viene gestito anche l'inserimento dell'altra immagine con eventuali errori da notificare all'utilizzatore del sito.
	 * @param $utente possessore del media
	 * @return bool
	 */
    static function modificaprofiloimmagine($account) {
    	$view = new VUser();
    	$pm = new FPersistentManager();
    	$ris = true;
    	$img1 = $pm->load("emailAccount", $account->getEmail(), "FMediaUser");
    	if (get_class($account) == "EAccount") {
    		if (isset($_FILES['file'])) {
				$nome_file = 'file';
    			$img = static::upload($account, "modificaAccount",$nome_file);
    			$user=FUser::loadByIdAccount($account);
    			switch ($img) {
    				case "size":
    					$ris = false;
    					$view->formModificaProfilo($user, $account, $img1, "errorSize");
    					break;
    				case "type":
    					$ris = false;
                        $view->formModificaProfilo($user, $account, $img1, "errorSize");
                        break;
					case "ok":
						$ris = true;
						break;
    			}
    		}

    	}
    	return $ris;
    }

}
