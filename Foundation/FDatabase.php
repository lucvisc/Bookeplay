<?php

require_once 'include.php';

if (file_exists('config.inc.php')) require_once 'config.inc.php';
/*  Singleton: rappresenta un tipo particolare di classe che garantisce
 *  che soltanto un'unica istanza della classe stessa possa essere creata
 *  all'interno di un programma
 */

/**
 * Lo scopo di questa classe e' quello di fornire un accesso unico al DBMS, cosi che l'accesso
 * ai dati persistenti da parte degli strati superiore dell'applicazione sia piu' intuitivo.
 *
 * @author Luca, Catriel
 * @package Foundation
 */
class FDatabase {


    /** l'unica istanza della classe */
    private static $instance;
    /** oggetto PDO che effettua la connessione al dbms */
    private $db;

    /** costruttore privato, l'unico accesso è dato dal metodo getInstance() */
    private function __construct () {
        try {
            $hostname="127.0.0.1";
            $dbname = "bookeplay";
            $user = "root";
            $pass= "";
            $this->db = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
        }
    }

    /**
     * funzione di supporto che serve a reperire solo il nome della tabella senza i riferiti campi
     * quando viene passato l'attributo values delle classi per le query che non siano di store
     * @param $Par la stringa del $values della classe da elaborare
     * @return nome della tabella di riferimento
     */
    public static function tabella ($Par){
        $pattern="/^(\w*)\s(\S*)$/"; //espressione regolare che separa le due substringhe
        preg_match($pattern , $Par, $result);
        return $result[1];
    }

    /**
     * Metodo che restituisce l'unica istanza dell'oggetto.
     * @return FDataBase l'istanza dell'oggetto.
     */
    public static function getInstance ()
    { //restituisce l'unica istanza (creandola se non esiste gia')
        if (self::$instance == null) {
            self::$instance = new FDatabase();
        }
        return self::$instance;
    }

    public function closeDbConnection() //funzione ausiliaria che pone il paramentro instance a null e che quindi
    {                                   // chiude la connessione al DB
        static::$instance = null;
    }

    /**
     * Metodo che permette di salvare informazioni contenute in un oggetto Entity sul database.
     * @param class classe da passare
     * @param obj oggetto da salvare
     * @return $id id dell'oggetto inserito
     */

    public function storeDB ($class, $obj) {
        //viene passato il nome della classe che ermetterà di richiamare tutti i metodi di classe
        try {
            print_r($obj);
            $this->db->beginTransaction();// inizio di una transazione
            $query = 'INSERT INTO ' . $class::getTables() . ' VALUES ' . $class::getValues();//costruzione della query
            print ("$query\n");
            $stmt = $this->db->prepare($query);                         // prepara la query restituendo l'oggetto query
            $class::bind($stmt, $obj);//fa il matching tra i parametri ed i valori delle variabili
            $stmt->execute();//esecuzione dell'oggetto stmt
            print_r($this->db->errorInfo());
            $id = $this->db->lastInsertId();                // Returns the ID of the last inserted row or sequence value
            $this->db->commit();                            // rende definitiva la transazione
            print_r($this->db->errorInfo());
            $this->closeDbConnection();                     //chiudiamo la connessione al db
            return $id;                                     //Ritorna l'id del record appena inserito nel db
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Metodo ci dupporto per le load degli oggetti presenti nelle varie tabelle
     * @param $class classe del foundation che sfrutta il metodo
     * @param $field campo da usare per la ricerca
     * @param $id valore da usare per la ricerca
     * @return array|mixed|null valore che cambia a seconda che il risultato sia zero, uono o più oggetti
     */
    public function loadDB ($class, $field, $id)
    {
        try {
            $query = "SELECT * FROM " . self::tabella($class::getTables()). " WHERE " . $field . "='" . $id . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            //print_r($this->db->errorInfo());
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                             //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                       //ritorna un array di righe.
            }
            return $result;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Metodo che restituisce il numero di righe ineteressate dalla query
     * @param $class classe del foundation che sfrutta il metodo
     * @param $field campo da usare per la ricerca
     * @param $id valore da usare per la ricerca
     * @return int|null
     */
    public function interestedRows ($class, $field, $id)
    {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE " . $field . "='" . $id . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $this->closeDbConnection();
            return $num;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Metodo che permette di eliminare un'istanza di una classe nel db
     * @param $class classe interessata
     * @param $field campo usato per la cancellazione
     * @param $id ,id usato per la cancellazione
     * @return bool|null a seconda se la cancellazione è avvenuta o meno
     */
    public function deleteDB ($class, $field, $id) {
        try {
            $result = null;
            $this->db->beginTransaction();
            $esiste = $this->existDB($class, $field, $id);
            if ($esiste) {
                $query = "DELETE FROM " . self::tabella($class::getTables()). " WHERE " . $field . "='" . $id . "';";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $this->db->commit();
                $this->closeDbConnection();
                $result = true;
            }
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            //return false;
        }
        return $result;
    }

    /**
     * Metodo che permette di aggiornare il valore di un attributo passato come parametro
     * @param $class ,classe interessata
     * @param $field campo da aggiornare
     * @param $newvalue nuovo valore da inserire
     * @param $pk chiave primaria della classe interessata
     * @return bool|null a seconda se la modifica è avvenuta o meno
     */
    public function updateDB ($class, $field, $newvalue, $pk, $id) {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . self::tabella($class::getTables()) . " SET " . $field . "='" . $newvalue . "' WHERE " . $pk . "='" . $id . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->db->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Metodo che verifica l'esistenza di un oggetto nel database
     * @param $class nome della classe
     * @param $field campo della classe usato per la verifica
     * @param $id valore da usare come parametro di ricerca
     * @return array|null a seeconda se l'oggetto esiste o meno nella tabella presa in esame
     */
    public function existDB ($class, $field, $id) {
        try {
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE " . $field . "='" . $id . "'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) == 1)
                return $result[0];  //rimane solo l'array interno
            else if (count($result) > 1)
                return $result;  //resituisce array di array
            $this->closeDbConnection();
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Metodo che verifica l'accesso di un utente , controllando che le credenziali (email e password) siano presenti nel db
     * @param $email ,email dell'account dell' utente
     * @param $pass, password dell'account dell'utente
     * @return mixed|null a seconda se l'account dell'utente è presente o meno della tabella
     */
    public function loadVerificaAccesso ($email, $pass) {
        try {
            $query = null;
            $class = "FAccount";
            $query = "SELECT * FROM " . $class::getTables() . " WHERE email ='" . $email . "' AND password ='" . $pass . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                 //nessuna riga interessata. return null
            } else {                             //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            }
            return $result;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione utilizzata per ritornare i giorni.
     * Utilizzata nella pagina admin
     * @param $state  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function getGiorni ($giorno) {
        try {
            $query = "SELECT * FROM giorno WHERE  Giorno = " . $giorno . " ;";
            $stmt = $this->db->prepare($query);

            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione utilizzata per ritornare le partite con uno specifico livello
     * Utilizzata nel momento in cui si filtra per livello
     * @param $livello che defisce il livello di una partita
     * @return array|null
     */
    public function getLivello ($livello) {
        try {
            $query = "SELECT * FROM partita WHERE  Livello = " . $livello . " ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione utilizzata per ritornare le partite
     * Utilizzata nella ricerca di una partita dato un giorno
     * @param $giorno definisce tutte le partire che possono essere giocate in un giorno
     * @return array|null
     */
    public function getPartite($giorno) {
        try {
            $query = "SELECT giorno,fascia FROM giorno, fasceorarie WHERE idFasciaOraria=idFascia AND giorno = " . $giorno . " ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione utilizzata per ritornare le partite disponibili
     * Utilizzata nella ricerca di una partita disponibile dato un giorno
     * @param $giorno definisce tutte le partire disponibili che sono presenti per un determinato giorno
     * @return array|null
     */
    public function getPartiteDisp($giorno) {
        try {
            $query = "SELECT giorno,fascia FROM giorno, fasceorarie WHERE idFasciaOraria=idFascia AND disp='Disponibile' AND giorno = " . $giorno . " ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Da una tupla ricevuta di una query istanzia l'oggetto corrispondente
     * @param class il nome della classe
     * @param row array la tupla restituita dal dbms
     * @return obj l'oggetto risultato dell'elaborazione
     */
    private function createObjectFromRow(string $class, $row)
    {
        $obj = NULL; //oggetto che conterra' l'istanza dell'elaborazione

        if (class_exists($class)) {
            $obj = $class::createObjectFromRow($row);
        }
        return $obj;
    }

    /**
     * Metodo che aggiunge una nuova possibile prenotazione creata nel db
     * @param $idPren , id della prenotazione
     * @param $idAcc , id dell'account che ha effettuato la prenotazione
     * @return false|PDOStatement|null
     */
    public function insertPren_creata($idPren, $idAcc) {
        try {
            $this->db->beginTransaction();
            $id = $this->db->query("INSERT INTO pren_creata (idPren, idAcc) VALUES('$idPren','$idAcc')");
            $this->db->commit();
            $this->closeDbConnection();
            return $id;

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }
    /**
     * Metodo che aggiunge una prenotazione nel db
     * @param $idPren , id della prenotazione
     * @param $idAcc , id dell'account che sta partecipando alla prenotazione
     * @return false|PDOStatement|null
     */
    public function insertPren_partecipa($idPren, $idAcc) {
        try {
            $this->db->beginTransaction();
            $id = $this->db->query("INSERT INTO pren_partecipa (idPren, idAcc) VALUES('$idPren','$idAcc')");
            $this->db->commit();
            $this->closeDbConnection();
            return $id;

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }
    /**
     * Metodo che aggiunge una possibile fascia oraria
     * @param $idFascia, id della fascia oraria su cui effettuare una prenotazione
     * @param $fasce, orario a disposizione
     * @param $disp, per verificare se una fascia oraria è disponibile o meno
     * @return false|PDOStatement|null
     */
    public function insertFasceorarie ($idFascia, $Fascia, $disp) {
        try {
            $this->db->beginTransaction();
            $id = $this->db->query("INSERT INTO fasceorarie (idFascia, Fascia, disp) VALUES('$idFascia','$Fascia','$disp')");
            $this->db->commit();
            $this->closeDbConnection();
            return $id;

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }


    /**
     * Funzione utilizzata per ritornare l'account specificato.
     * Utilizzata nella pagina admin
     * @param $state  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function getAccount ($acc) {
        try {
            echo $acc;
            $query = "SELECT * FROM account WHERE  username = '" . $acc . " ';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            print_r($this->db->errorInfo());
            $num = $stmt->rowCount();
            print ("$num\n") ;
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            print_r($result);
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * @return il numero degli utenti nel database
     */
    public function ContaUtenti()
    {
        try {
            $query=("SELECT COUNT(*) FROM account");
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $result = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * @return la somma di tutti i conti di tutti gli utenti oppure |null in caso di errore
     */
    public function ContoTot(){
            try {
                $query=("SELECT SUM(conto) as totale FROM account GROUP BY (id)");
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Attenzione errore: " . $e->getMessage();
                $this->db->rollBack();
                return null;
            }
    }

    /**
     * Funzione utilizzata per ritornare le prenotazioni di un specifico giorno.
     * Utilizzata nella pagina admin
     * @param $state  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function getBooking ($giorno) {
        try {
            $query = "SELECT * FROM prenotazione where giorno=".$giorno."  ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione utilizzata per ritornare lo user specificato.
     * Utilizzata nella pagina admin
     * @param $state  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function getUser ($us) {
        try {
            $query = "SELECT * FROM user WHERE  idacc = " . $us . " ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }






    /******************RICERCA*******************/

    /**
     * Funzione utilizzata per ritornare tutti gli utenti che verificano determinate caratteristiche date in input
     * Utilizzata nella pagina admin
     * @param $array di valori da cercare (massimo 2 : nome e cognome)
     * @param $toSearch se 'nome' ho in input un solo valore, altrimenti ne ho due
     * @return array $num numero di righe che rispettano la ricerca, $result oggetti che rispettano la ricerca
     */
    public function utentiByString ($array, $toSearch)
    {
        if ($toSearch == 'nome')
            $query = "SELECT * FROM account where name = '" . $array[0] . "' OR surname = '" . $array[0] . "';";
        else
            $query = "SELECT * FROM account where name = '" . $array[0] . "' AND surname = '" . $array[1] . "' OR name = '" . $array[1] . "' AND surname = '" . $array[0] . "';";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0)
            $result = null;
        elseif ($num == 1)
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        else {
            $result = array();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch())
                $result[] = $row;
        }
        return array($result, $num);
    }

    /**
     * Funzione utilizzata per ritornare gli utenti attivi e bannati.
     * Utilizzata nella pagina admin
     * @param $state  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function getUtenti ($tipo) {
        try {
            $query = "SELECT * FROM user WHERE  tipo = " . $tipo . " AND email <> 'admin@admin.com';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione utilizzata per garantire una ricerca mirata da parte dell'admin.
     * @param $input stringa inserita nel campo ricerca dall'admin
     * @param $class classe interessata nella ricerca
     * @param $campo campo dove cercare la parola
     * @return array|null a seconda se la parola è presente eo meno nel database
     */
    public function ricercaParola ($input, $class, $campo) {
        try {
            $query = "SELECT * FROM " . $class::getTable() . " WHERE " . $campo . " LIKE '%" . $input . "%';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                             //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                       //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * @param $cont
     * @param string $str
     * @return |null
     */
    function cerca($cont, string $str)
    {
        $sql = '';
        if ($cont == 0) {
            $method = 'cercaUtenteByUsername';
            $sql = FUser::$method();
            $className = 'Utente';
            $value = 'Username';
        } else if ($cont == 1) {
            $method = 'cercaPrenotazioneByGiorno';
            $sql = FBooking::$method();
            $className = 'Prenotazione';
            $value = 'Giorno';
        } else if ($cont == 2) {
            $method = 'cercaPrenotazioneByFascia';
            $sql = FBooking::$method();
            $className = 'Prenotazione';
            $value = 'Fascia';
        }
        if ($sql)
            return $this->exeCerca('F' . $className, $value, $str, $sql);
        else return NULL;
    }
}
?>

