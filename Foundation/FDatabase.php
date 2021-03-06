<?php

require_once 'include.php';

if (file_exists('config.inc.php')) require_once 'config.inc.php';
/*  Singleton: rappresenta un tipo particolare di classe che garantisce
 *  che soltanto un'unica istanza della classe stessa possa essere creata
 *  all'interno di un programma
 */

/**
 * Lo scopo di questa classe e' quello di fornire un accesso unico al DBMS, cosi che l'accesso
 * ai dati persistenti da parte degli strati superiori dell'applicazione sia piu' intuitivo.
 *
 * @author Luca, Catriel
 * @package Foundation
 */
class FDatabase
{

    /** l'unica istanza della classe */
    private static $instance;
    /** oggetto PDO che effettua la connessione al dbms */
    private $db;

    /** costruttore privato, l'unico accesso è dato dal metodo getInstance() */
    private function __construct()
    {
        try {
            //$this->db = new PDO ("mysql:host=".$GLOBALS['hostname'].";dbname=".$GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);
            $this->db = new PDO ("mysql:dbname=" . $GLOBALS['database'] . ";host=localhost; charset=utf8;", $GLOBALS['username'], $GLOBALS['password']);
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
    public static function tabella($Par)
    {
        $pattern = "/^(\w*)\s(\S*)$/"; //espressione regolare che separa le due substringhe
        preg_match($pattern, $Par, $result);
        return $result[1];
    }

    /**
     * Metodo che restituisce l'unica istanza dell'oggetto.
     * @return FDataBase l'istanza dell'oggetto.
     */
    public static function getInstance()
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
    public function storeDB($class, $obj)
    {
        //viene passato il nome della classe che ermetterà di richiamare tutti i metodi di classe
        try {

            $this->db->beginTransaction();// inizio di una transazione
            $query = 'INSERT INTO ' . $class::getTables() . ' VALUES ' . $class::getValues();//costruzione della query
            $stmt = $this->db->prepare($query);                         // prepara la query restituendo l'oggetto query
            $class::bind($stmt, $obj);//fa il matching tra i parametri ed i valori delle variabili
            $stmt->execute();//esecuzione dell'oggetto stmt
            $id = $this->db->lastInsertId();// Returns the ID of the last inserted row or sequence value
            $this->db->commit();// rende definitiva la transazione
            $this->closeDbConnection();                     //chiudiamo la connessione al db
            return $id;                                     //Ritorna l'id del record appena inserito nel db
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Funzione che si occupa del salvataggio di un media nel database
     * @param $class classe dell'oggetto da salvare
     * @param $obj oggetto da salvare nel database
     * @param $nome_file nome della chiave dell'array superglobale $_FILE
     * @return string|null
     */
    public function storeMedia($class, $obj)
    {
        try {
            $this->db->beginTransaction();
            $query = 'INSERT INTO ' . $class::getTables() . ' VALUES ' . $class::getValues();
            $stmt = $this->db->prepare($query);
            $class::bind($stmt, $obj);
            $stmt->execute();
            $id = $this->db->lastInsertId();
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
     * Metodo utilizzato per aggiornare l'immagine di un utente
     * @param $obj oggetto utente di riferimento
     * @param $media nuovo da mettere
     * @return string|null
     */
    public function UpdateImg($obj, $media) {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE mediauser SET `immagine`= ".FMediaUser::getImmagine()." where emailutente='".$obj->getEmailUser()."';";
            $stmt = $this->db->prepare($query);
            FMediaUser::bindImg($stmt, $obj, $media);
            $stmt->execute();
            $id = $this->db->lastInsertId();
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
     * Metodo di supporto per le load degli oggetti presenti nelle varie tabelle
     * @param $class classe del foundation che sfrutta il metodo
     * @param $field campo da usare per la ricerca
     * @param $id valore da usare per la ricerca
     * @return array|mixed|null valore che cambia a seconda che il risultato sia zero, uono o più oggetti
     */
    public function loadDB($class, $field, $id)
    {
        try {
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE " . $field . "='" . $id . "';";
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
    public function interestedRows($class, $field, $id)
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
    public function deleteDB($class, $field, $id)
    {
        try {
            $result = null;
            $this->db->beginTransaction();
            $esiste = $this->existDB($class, $field, $id);
            if ($esiste) {
                $query = "DELETE FROM " . self::tabella($class::getTables()) . " WHERE " . $field . "='" . $id . "';";
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
    public function updateDB($class, $field, $newvalue, $pk, $id)
    {
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
    public function existDB($class, $field, $id)
    {
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
     * Metodo che verifica se il giorno è la fascia oraria è gia presente nel db
     * @param $giorno giorno della prenotazione
     * @param $fasciaoraria della prenotazione
     * @return mixed|null a seconda se è presente o meno della tabella
     */
    public function loadVerificaGiorno($giorno, $fasciaoraria)
    {
        try {
            $query = null;
            $class = "FGiorno";
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE Giorno ='" . $giorno . "' AND FasciaOraria ='" . $fasciaoraria . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                  //nessuna riga interessata. return null
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
     * Metodo di supporto per le load degli oggetti presenti nelle varie tabelle
     * @param $class classe del foundation che sfrutta il metodo
     * @param $field campo da usare per la ricerca
     * @param $id valore da usare per la ricerca
     * @return array|mixed|null valore che cambia a seconda che il risultato sia zero, uono o più oggetti
     */
    public function loadGiornoFascia($class, $field, $id)
    {
        try {
            $query = "SELECT Giorno, FasciaOraria FROM " . self::tabella($class::getTables()) . " WHERE " . $field . "='" . $id . "';";
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
            return $result;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Metodo che restituisce una prenotazione effettuata dati una specifica fasciaoraria e un giorno
     * @param $giorno giorno della prenotazione
     * @param $fasciaoraria della prenotazione
     * @return mixed|null a seconda se è presente o meno della tabella
     */
    public function loadPrenotazioneEff($giorno, $fasciaoraria)
    {
        try {
            $query = null;
            $class = "FBooking";
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE Giorno ='" . $giorno . "' AND FasciaOraria ='" . $fasciaoraria . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                  //nessuna riga interessata. return null
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
     * Metodo che conta quanti partecipanti ci sono per una prenotazione
     * @param $idPre id della prenotazione
     * @return numero di partecipanti
     */
    public function CountPartecipanti($idPre)
    {
        try {
            $query = null;
            $class = "FPren_partecipa";
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE idPren ='" . $idPre . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            return $num;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Metodo che verifica l'accesso di un utente , controllando che le credenziali (email e password) siano presenti nel db
     * @param $email ,email dell'account dell' utente
     * @param $pass , password dell'account dell'utente
     * @return mixed|null a seconda se l'account dell'utente è presente o meno della tabella
     */
    public function loadVerificaAccesso($email, $pass)
    {
        try {
            $query = null;
            $class = "FAccount";
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE email ='" . $email . "' AND password ='" . $pass . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                  //nessuna riga interessata. return null
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
     * Metodo che verifica se esiste la prenotazione per un eventuale modifica da parte del client
     * @param $email ,email dell'account dell' utente
     * @param $idPren , id di prenotazione d'interesse
     * @return mixed|null a seconda se l'account dell'utente è presente o meno della tabella
     */
    public function loadVerificaPrenotazione($idPren, $email)
    {
        try {
            $query = null;
            $class = "FPren_partecipa";
            $query = "SELECT * FROM " . self::tabella($class::getTables()) . " WHERE idPren ='" . $idPren . "' AND email ='" . $email . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;                  //nessuna riga interessata. return null
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
     * Funzione utilizzata per ritornare tutte le fascie orarie di un giorno specifico.
     * Utilizzata nella pagina admin
     * @param $giorno  giorno specifico
     * @return array|null
     */
    public function getGiorni($giorno)
    {
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
     * Metodo che elimina un partecipante ad una prenotazione nel db
     * @param $idPren , id della prenotazione
     * @param $email , email dell'account che sta partecipando alla prenotazione
     * @return false|PDOStatement|null
     */
    public function deletePrenPartecipa($idPren, $email)
    {
        try {
            $this->db->beginTransaction();
            $query = "DELETE FROM  pren_partecipa  WHERE idPren='" . $idPren . "' AND email='" . $email . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->db->commit();
            $this->closeDbConnection();
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }


    /**
     * Metodo che aggiunge un partecipante ad una prenotazione nel db
     * @param $idPren , id della prenotazione
     * @param $email , email dell'account che sta partecipando alla prenotazione
     * @return false|PDOStatement|null
     */
    public function insertPren_partecipa($idPren, $email)
    {
        try {
            $this->db->beginTransaction();
            $query = ("INSERT INTO pren_partecipa VALUES('".$idPren."'".",'". $email."')");
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->db->commit();
            $this->closeDbConnection();
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Metodo che aggiunge una possibile fascia oraria
     * @param $idFascia , id della fascia oraria su cui effettuare una prenotazione
     * @param $fasce , orario a disposizione
     * @param $disp , per verificare se una fascia oraria è disponibile o meno
     * @return false|PDOStatement|null
     */
    public function insertFasceorarie($idFascia, $Fascia, $disp)
    {
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
     * Metodo che aggiunge un nuovo possibile giorno nel db
     * @param $id , fk booking
     * @return false|PDOStatement|null
     */
    public function insertGiorno($id)
    {
        try {
            $this->db->beginTransaction();
            $id = $this->db->query("INSERT INTO giorno (id) VALUES($id);");
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
     * Funzione utilizzata per ritornare gli account attivi (non bloccati) sul sito
     * Utilizzata nella pagina admin
     * @param $input  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function loadAcc($input) {
        try {
            $query = "SELECT * FROM account, utente WHERE  account.email=utente.email AND tipo='registrato' AND activate = " . $input . " ;";
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
     * Funzione utilizzata per ritornare l'account specificato.
     * Utilizzata nella pagina admin
     * @param $state  valore booleano che definisce lo stato degli utenti desiderati
     * @return array|null
     */
    public function getAccount($acc)
    {
        try {
            echo $acc;
            $query = "SELECT * FROM account WHERE  username = '" . $acc . " ';";
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
     * Funzione utilizzata per ritornare le prenotazioni di un specifico giorno.
     * Utilizzata nella pagina admin
     * @param $giorno  giorno di interesse per la query
     * @return array|null
     */
    public function getBooking($giorno)
    {
        try {
            $query = "SELECT * FROM prenotazione where Giorno=" . "'" . $giorno . "'" . "  ;";
            echo $query;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            //print_r($stmt->errorInfo());
            $num = $stmt->rowCount();
            echo $num;
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
     * Funzione utilizzata per ritornare i partecipanti di una specifica prenotazione.
     * Utilizzata nella pagina admin
     * @param $idPrend id della prenotazione della quale si vuole conoscere il numero dei partecipanti
     * @return array|null
     */
    public function getPrenotazionePartecipa($idPren)
    {
        try {
            $query = "SELECT * FROM pren_partecipa where idPren=" . "'" . $idPren . "'" . "  ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            //print_r($stmt->errorInfo());
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $comodo = $stmt->fetch(PDO::FETCH_ASSOC);//ritorna una sola riga
                $result = $comodo['email'];
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row['email'];                   //ritorna un array di righe.
            }
            return array($result);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }


    /**
     * Metodo utelizzato per ritornare tutte le partite associate ad un specifico account
     * Utilizzata nella pagina admin
     * @param $email di un specifico account
     * @return array|null
     */
    public function Riepilogo($email)
    {
        try {
            $query = "SELECT idP, Quota, livello, Giorno, FasciaOraria, note FROM prenotazione, pren_partecipa  where idP=idPren AND email='" . $email . "';";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            //print_r($stmt->errorInfo());
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
     * Funzione utilizzata per ritornare solamente le partite attive
     * @return array|mixed|null
     */
    public function loadBooking()
    {
        try {
            $query = "SELECT * FROM prenotazione ;";
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
     * Funzione utilizzata per ritornare lo user specificato.
     * Utilizzata nella pagina admin
     * @param $us id dell'utente associato anche al corrispettivo account
     * @return array|null
     */
    public function getUser($us)
    {
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


    /**
     * Metodo he restituisce il numero dei partecipanti
     * @param $id della prenotazione della quale si vogliono conoscere i patecipanti
     * @return int|null
     */
    public function getCountPartecipa($id)
    {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM pren_partecipa where idPren=$id";
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
}
?>

