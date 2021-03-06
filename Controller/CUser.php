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
        if ($account != null && $account->getActivate() != 0 ){
            if (session_status() == PHP_SESSION_NONE) {         //se nella sessione non è presente alcun parametro
                session_set_cookie_params('3600');       // setta i cookie e la sessione ad 1 ora dal login
                session_start();
                $salvare = serialize($account);                 //salviamo l'account di chi ha effettuato l'accesso
                $_SESSION['account'] = $salvare;                //nella variabile globale poiché consideriamo che l'HTTP è un protocollo
                if ($_POST['email'] != 'admin@admin.com') {     //senza stato
                    if (isset($_COOKIE['nome_visitato'])) {
                        header('Location: /BookAndPlay/User/profiloUtente');
                    }
                    else {
                        header('Location: /BookAndPlay/User/profiloUtente');
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
     * Metodo che verifica se l'utente è loggato, attreverso la verifia sul PHPSESSID, se lo status delle sessione è
     * vuoto allora iniziane uno con session_start() che è un session ID che trasmette tra il browser ed il server le
     * richieste HTTP, se il PHPSESSID non esiste ma esite la SESSION con allora poni l'identificativo uguale a true che
     * specifica che l'utente o l'admin sono gia loggati
     * Questa funzione puo essere utilizzata soprattutto per controllare se un utente non loggato prova ad accedere
     * ad un URL di un utente loggato
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


	/**
	 * Funzione che provvede alla rimozione delle variabili di sessione, alla sua distruzione e a rinviare alla homepage
	 */
	static function logout(){
     // session_name('BookAndPlay');
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
     * Funzione utilizzata per visualizzare l'errore
     */
	public function error() {
    	$view = new VError();
    	$view->error('1');
	}

    /**
     *Metodo che mostra il profilo dell'utente loggato o il profilo di un altro utente a seconda del tipo di URL:
     */
    static function profiloUtente() {
        $view = new VUser();
        $pm = new FPersistentManager();
        if (CUser::isLogged()) {
            $account = unserialize($_SESSION['account']);
            if (get_class($account) == "EAccount") {
                if($account->getEmail() != 'admin@admin.com'){
                    $img = $pm->loadImg($account->getEmail());
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $addr = $pm->load("email", $account->getEmail(), "FAddress");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showProfileUser($user, $acc, $addr, $img);
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


    /**
     * Metodo che mostra il profilo dell'utente loggato
     */
    static function profilo() {
        $view = new VUser();
        $pm = new FPersistentManager();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUser::isLogged())
                $account= unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {

                    $img = $pm->loadImg($account->getEmail());
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
	 * 1) se il metodo della richiesta HTTP è GET e si è loggati, avviene il reindirizzamento alla pagina del profilo;
	 * 2) se il metodo della richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento vero e proprio alla form di registrazione;
	 * 3) se il metodo della richiesta HTTP è POST viene invocato il metodo di registrazione che si occupa di gestire
     * i dati inseriti nella form
	 */
	static function registrazioneUtente(){
		if($_SERVER['REQUEST_METHOD']=="GET") {
			$view = new VUser();
			if (static::isLogged()) {
                $account = unserialize($_SESSION['account']);
                if (get_class($account) == "EAccount") {
                    $pm = new FPersistentManager();
                    $img = $pm->loadImg($account->getEmail());
                    $user = $pm->load("email", $account->getEmail(), "FUser");
                    $addr = $pm->load("email", $account->getEmail(), "FAddress");
                    $acc = $pm->load("email", $account->getEmail(), "FAccount");
                    $view->showProfileUser($user, $acc, $addr, $img);
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
	 * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per un utente
	 * In questo metodo avviene in primo luogo la verifica sull'univocità dell'email inserita;
	 * se non ci sono problemi sull'email, si passa verifica dell'immagine inserita e successivamente al salvataggio dei
     * dati immessi dall'utente che intende registrarsi
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
            $pm::storeReg($account,$user, $addr);
            if ($account != null) {
				if (isset($_FILES['file'])) {
					$nome_file = 'file';
					$img = static::upload($account,"VerificaRegistrazioneUser",$nome_file);
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
     * Funzione che ha il compito di richiamare la form della modifica del profilo e successivamente di reperire i dati immessi
     * 1) se il metodo della richiesta HTTP è GET e si è loggati, viene presentata la pagina per modificare i propri dati;
     * 2) se il metodo della richiesta HTTP è GET ma non si è loggati, allora avviene il reindirizzamento verso la form di login;
     * 3) se il metodo della richiesta HTTP è POST, vengono rilevati tutti i valori inseriti dall'utente per la modifica
     * e dopo aver controllato l'esistenza dell'email e la correttezza della password inserita si passa alla modifica
     * vera e propria del profilo
     */
    public function modificaProfilo() {
        $pm = new FPersistentManager();
        $view = new VUser();
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUser::isLogged()) {
                $account = unserialize($_SESSION['account']);
                $user = $pm->load("email", $account->getEmail(), "FUser");
                $addr = $pm->load("email", $account->getEmail(), "FAddress");
                $acc = $pm->load("email", $account->getEmail(), "FAccount");
                $img = $pm->loadImg($account->getEmail());
                $view->formModificaProfilo($user, $acc, $img, "ok"); //

            } else
                header('Location: /BookAndPlay/User/login');
        }
        elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

            $account = unserialize($_SESSION['account']);  //Creates a PHP value from a stored representation
            $pm = new FPersistentManager();
            $img = $pm->loadImg($account->getEmail());
            $acc = $pm->load("email", $account->getEmail(), "FAccount");
            $user = $pm->load("email", $account->getEmail(), "FUser");
            $addr = $pm->load("email", $account->getEmail(), "FAddress");
            if (get_class($account) == "EAccount") {
                if ($account->getPassword() == $_POST['old_password']) {
                    if ($account->getEmail() == $_POST['email']) {
                        static::updateCampi($account, "FAccount", $_POST['username'], $_POST['new_password']);
                        $newAcc = $pm->load('email',$account->getEmail(), "FAccount");
                        $salvare = serialize($newAcc);
                        $_SESSION['account'] = $salvare;

                        $statoimg = static::modificaprofiloimmagine($account);
                        if ($statoimg) { //Update della l'immagine di profilo
                            $img = $pm->loadImg($newAcc->getEmail());

                            $view->formModificaProfilo($user, $newAcc, $img, 'ok' );
                        }
                        else {
                            header('Location: /BookAndPlay/User/profilo');
                        }
                    }
                    else {
                        $verificaEmail = $pm->exist("email", $_POST['email'], "FAccount");
                        if ($verificaEmail) {
                            //UTENTE GIA NEL DB
                            $view->formModificaProfilo($user, $acc, $img, "errorEmail"); //
                        }
                        else {
                            static::updateCampi($account, "FAccount", $_POST['username'], $_POST['new_password']);
                            $pm->update("email", $_POST['email'], "email", $account->getEmail(), "FAccount");
                            $newAcc=$pm->load("email", $account->getEmail(), "FAccount");
                            $user = $pm->load("email", $account->getEmail(), "FUser");
                            $addr = $pm->load("email", $account->getEmail(), "FAddress");
                            $salvare = serialize($newAcc);
                            $_SESSION['account'] = $salvare;
                            $statoimg = static::modificaprofiloimmagine($account);
                            if ($statoimg) {
                                $img = $pm->loadImg($account->getEmail());
                            }
                            $view->showProfileUser($user, $newAcc, $addr, $img);
                        }
                    }
                } else {
                    //ERRORE PASSWORD
                    $view->formModificaProfilo($user, $acc, $img ,'errorPassw');
                }
            }
            else {
                header('Location: /BookAndPlay/User/login');
            }
        }
    }
    /**
     * Funzione di supporto per la modifica del profilo
     * Questa funzione, grazie alla chiamata della funzione upload(), si occupa di gestire il comportamento della form
     * rispetto all'inserimento delle immagini e fornendo la possibilià di notificare degli errori
     * @param $account che possiede un'immagine
     * @return bool
     */
    static function modificaprofiloimmagine($account) {
        $view = new VUser();
        $pm = new FPersistentManager();
        $ris = true;
        $img1 = $pm->loadImg($account->getEmail());
        if (get_class($account) == "EAccount") {
            if (isset($_FILES['file'])) {
                $nome_file = 'file';
                $img = static::upload($account, "modificaUser",$nome_file);
                $user=$pm->load('email', $account->getEmail(), "FUser");
                $acc=$pm->load('email', $account->getEmail(), "FAccount");
                switch ($img) {
                    case "size":
                        $ris = false;
                        $view->formModificaProfilo($user, $acc, $img1, "errorSize");
                        break;
                    case "type":
                        $ris = false;
                        $view->formModificaProfilo($user, $acc, $img1, "errorType");
                        break;
                    case "ok":
                        $ris = true;
                        break;
                }
            }
        }
        return $ris;
    }

    /**
     * Funzione di supporto che si occupa di verificare la correttezza dell'immagine inserita nella form di registrazione.
     * e nella form di modifica
     * Nel caso in cui non ci sono errori di inserimento, avviene la store dell'utente e la corrispondente immagine nel database.
     * @param $account object Account
     * @param $funz tipo di funzione da svolgere, poiché è utilizzata da più funzioni
     * @param $nome_file passato nella form per l'immagine
     * @return string stato
     */
    static function upload($account,$funz,$nome_file) {
        $pm = new FPersistentManager();
        $ris = null;
        $nome = '';
        $max_size = 300000;
        $result = is_uploaded_file($_FILES[$nome_file]['tmp_name']);  //verifica se il file è stato passato dall'utente
        if (!$result) {
            //no immagine
            if ($funz == "showFormRegistration") {
                $ris = "ok";
            }
        }
        else {
            $size = $_FILES[$nome_file]['size'];
            $type = $_FILES[$nome_file]['type'];
            $data= file_get_contents($_FILES[$nome_file]['tmp_name']);
            if ($size > $max_size) {       //Il file è troppo grande
                $ris = "size";
            }
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $nome = $_FILES[$nome_file]['name'];
                if ($funz == "showFormRegistration") {
                    $mediaUser= new EMediaUser($nome,$account->getEmail(),$type, $data);
                    $pm->storeMedia($mediaUser);
                    $ris = "ok";
                }
                elseif ($funz == "modificaUser") {
                    $mediaUser= new EMediaUser($nome,$account->getEmail(),$type, $data);
                    $pm->UpdateImg($mediaUser, $data);
                    $ris= "ok";
                }
                elseif($funz == "VerificaRegistrazioneUser"){
                    $mediaUser= new EMediaUser($nome,$account->getEmail(),$type, $data);
                    $pm->storeMedia($mediaUser);
                    $ris = "ok";
                }
            }
            else {     //il media è in un formato diverso e non può essere salvato
                $ris = "type";
            }
        }
        return $ris;
    }

    /**
     * Funzione che si occupa di fare tutti i controlli necessari per aggiornare i campi che un utente desidera modificare
     * nella sua form di modifica profilo, viene utilizzata dalla function modificaProfilo
     * @param $account obj rappresentante l'account di un user
     * @param $class classe del account che richiede le modifiche
     * @param $username variabile inserita da input (reperita da $_POST['username'])
     * @param $pass variabile inserita da input (reperita da $_POST['password'])
     */
    static private function updateCampi($account,$class, $username, $pass) {
        $pm = new FPersistentManager();
        if ($account->getUsername() != $username)
            $pm->update("username", $username, "email", $account->getEmail(), $class);
        if ($_POST['new_password'] != "")
            $pm->update("password", $pass, "email", $account->getEmail(), $class);
    }

}
?>
