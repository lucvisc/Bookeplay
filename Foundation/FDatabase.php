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

    private static $instance = null;     /** l'unica istanza della classe */
    private $db;                         /** oggetto PDO che effettua la connessione al dbms */

    /** dichiarazione del costruttore privato, l'unico accesso è dato dal metodo getInstance() */
    /*private function __construct()
    {
        global $host, $bookeplay, $username, $password;
        try {
            $this->db = new PDO("mysql:host=$host; dbname=$bookeplay", $username, $password);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
        }
        return $this->db;
    }*/
    private function __construct () {
        try {
            $this->db = new PDO ("mysql:dbname=".$GLOBALS['database'].";host=localhost; charset=utf8;", $GLOBALS['username'], $GLOBALS['password']);

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
        }

    }

    /**
     * Metodo che restituisce l'unica istanza dell'oggetto.
     * @return FPersistantManager l'istanza dell'oggetto.
     */
    public static function getInstance()    //restituisce l'unica istanza di FDatabase, l'istanza viene creata se non esiste
    {
        if (static::$instance == null) {
            static::$instance = new FDatabase();
        }
        return static::$instance;
    }

    public function closeDbConnection() //funzione ausiliaria che pone il paramentro instance a null e che quindi
    {                                   // chiude la connessione al DB
        static::$instance = null;
    }

    /**
     * Metodo che permette di salvare le informazioni contenute in un oggetto
     * delle classe Entity sul database.
     */
    public function storeDB($class, $eobj)
    {
        try {
            $this->db->beginTransaction();      //Contrassegna il  punto di inizio di una transazione locale esplicita
            $query = "INSERT INTO " . $class::getTable() . " VALUES " . $class::getValues();
            $stmt = $this->db->prepare($query);   //prepara la query sql
            $class::bind($stmt, $eobj);         //costruisce l'oggetto della classe
            $stmt->execute();                   //esegue la query
            $id = $this->db->lastInsertId();    // Returns the ID of the last inserted row or sequence value
            $this->db->commit();                //Commette una transazione, restituendo la connessione del database alla modalità di autocommit fino alla successiva chiama a PDO :: beginTransaction () avvia una nuova transazione
            $this->closeDbConnection();         //Cambia l'attributo instance a nulle chiude la connessione al db
            return $id;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
                $this->db->rollBack();          //Contrassegna il punto di fine di una transazione locale esplicita
            die;
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
            $query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
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
            return $result;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione che viene utilizzata per la load quando ci si aspetta che la query produca più di un risultato
     * da salvare all'interno del database
     * @param $sql query da eseguire
     */
    public function loadMultiple($sql)
    {
        try {
            $rows = array();
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                $rows[] = $row;
            }
            $this->closeDbConnection();
            return $rows;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
            return null;
        }
    }

    /**
     * Funzione che viene utilizzata per la load quando ci si aspetta che la query produca un solo risultato
     * per esempio load tramite un parametro ID
     * @param $sql query da eseguire
     */
    public function loadSingle($sql)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->closeDbConnection();
            return $row;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
            return null;
        }
    }

    /**
     * Funzione che viene utilizzata per eliminare una riga quando si passa un unico paramentro (per esempio ID)
     * @param $sql query da eseguire
     */
    public function delete($sql)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $this->db->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            die;
            return false;
        }
    }

    /**
     * Funzione che viene utilizzata per aggiornare una riga quando si passa un unico paramentro (per esempio ID)
     * @param $sql query da eseguire
     */
    public function update($sql)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $this->db->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            die;
            return false;
        }
    }
    /**
     * Funzione che viene utilizzata per testare l'esistenza di una riga all'interno di un database quando
     * si passa un unico paramentro che identifica quella riga all'interno della tabella
     * @param $sql query da eseguire
     */
    public function exist($sql)
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) == 1) return $rows[0];
            else if (count($rows) > 1) return $rows;
            $this->closeDbConnection();
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
            return null;
        }
    }



    /******************RICERCA*******************/

    /**
     * Effettua una ricerca sul database secondo i parametri selezionati.
     * Tale metodo viene utilizzato per una ricerca avanzata da parte dell'utente.
     * @param key la table da cui prelevare i dati
     * @param value il valore per cui cercare i valori
     * @param str il dato richiesto dall'utente
     * @return array | NULL i risultati ottenuti dalla ricerca. Se la richiesta non ha match, ritorna NULL.
     */
    function cercaAv(string $key, string $value, string $str)
    {
        $sql = '';
        $className = 'F' . $key;

        if (class_exists($className)) {
            $method = 'cerca' . $key . 'By' . $value;
            if (method_exists($className, $method))
                $sql = $className::$method();
        }

        if ($sql)
            return $this->exeCerca('F' . $key, $value, $str, $sql);
        else return NULL;
    }

    /**
     * Funzione privata che prepara ed esegue la query.
     * @return obj torna l'oggetto (User) ricercato
     */
    private function exeCerca(string $className, string $value, string $str, string $sql)
    {
        try {
            $stmt = $this->db->prepare($sql);       // creo PDOStatement
            $stmt->bindValue(":" . lcfirst($value), $str, PDO::PARAM_STR); //si associa l'id al campo della query
            $stmt->execute();   //viene eseguita la query
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // i risultati del db verranno salvati in un array con indici le colonne della table

            $obj = NULL; // l'oggetto di ritorno viene definito come NULL

            while ($row = $stmt->fetch()) {                                 // per ogni tupla restituita dal db...
                $obj[] = FDatabase::createObjectFromRow($className, $row);  // si fa una istanza dell'oggetto
            }
            return $obj;
        } catch (PDOException $e) {
            return null;               // ritorna il parametro null se ci sono errori di vario tipo
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
     * Effettua una ricerca sul database secondo i parametri selezionati.
     * Tale metodo viene utilizzato per una ricerca da parte dell'utente.
     * @param cont parametro che indica quale gruppo di istruzioni eseguire
     * @param str il dato richiesto dall'utente
     * @return array | NULL i risultati ottenuti dalla ricerca. Se la richiesta non ha match, ritorna NULL.
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

