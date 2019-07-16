<?php
require_once 'include.php';

/**
 * La classe FPartita fornisce query per gli oggetti EPartita
 * @author Luca, Catriel
 * @package Foundation
 */
class FPartita
{
    /**
     * classe foundation
     */
    private static $class = "FPartita";
    /**
     * tabella di riferimento
     */
    private static $tables = "partita";
    /**
     * valori della tabella
     */
    private static $values = "(:idPren,:MaxNumGioc,:Livello,:Note)";

    public function __construct()
    {
    }

    /**
     * Questo metodo lega gli attributi della classe partita da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EPartita $par partita i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EPartita $par)
    {
        $stmt->bindValue(':idPren', NULL, PDO::PARAM_INT); //l'id è posto a NULL perche viene incrementato automaticamente dal DB
        $stmt->bindValue(':MaxNumGioc', $par->getNumMax(), PDO::PARAM_STR);
        $stmt->bindValue(':Livello', $par->getLivello(), PDO::PARAM_STR);
        $stmt->bindValue(':Note', $par->getNote(), PDO::PARAM_STR);
    }

    /**
     * questo metodo restituisce la classe per la costruzione delle Query
     * @return string $class classe della tabella di riferimento
     */
    public static function getClass()
    {
        return self::$class;
    }

    /**
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables()
    {
        return self::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */

    public static function getValues()
    {
        return self::$values;
    }

    /**
     * Metodo che permette la store di una partita
     * @param $Partita Partita da salvare
     */
    public static function store($partita)
    {
        $db = FDatabase::getInstance();
        $id = $db->storeDB(static::getClass(), $partita);
    }

    /**
     * Permette la load sul db
     * @param $id valore da confrontare per trovare l'oggetto
     * @param $field campo nel quale effettuare la ricerca
     * @return object $utente Utenteloggato
     */
    public static function loadByField($field, $id)
    {
        $partita = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if (($result != null) && ($rows_number == 1)) {  //:idPren,:MaxNumGioc,:Livello,:Note)
            $partita = new EPartita($result['idPren'], $result['MaxNumGioc'], $result['Livello'], $result['Note']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $partita = array();
                for ($i = 0; $i < count($result); $i++) {
                    $partita[] = new Epartita($result[$i]['idPren'], $result[$i]['MaxNumGioc'], $result[$i]['Livello'], $result[$i]['Note']);
                }
            }
        }
        return $partita;
    }

    /**
     * Funzione che permette di verificare se esiste una partita nel database
     * @param  $id valore di cui verificare la presenza
     * @param $field colonna su ci eseguire la verifica
     * @return bool
     */
    public static function exist($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->existDB(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if ($result != null)
            return true;
        else
            return false;
    }

    /**
     * Metodo che aggiorna i campi di una Partita
     * @param $field campo nel quale si vuole modificare il valore
     * @param $newvalue nuovo valore da assegnare
     * @param $pk nome della colonna utilizzata per l'espressione "where" della query
     * @param $id valore della primary key da usare come riferimento
     * @return true se esiste il mezzo, altrimenti false
     */
    public static function update($field, $newvalue, $pk, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
        if ($result)
            return true;
        else
            return false;
    }

    /**
     * Permette la delete sul db in base all'id
     * @param $field nome del campo della tabella nel quale ricercare il valore immesso
     * @param $id valore del campo
     * @return bool
     */
    public static function delete($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->deleteDB(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
        if ($result)
            return true;
        else
            return false;
    }

    /**
     * Metodo che permette di ritornare tutte le partite con un certo livello
     * @param $state valore dello stato
     * @return object $utente Utenteloggato
     */
    public static function loadLivello($livello)
    {
        $utente = null;
        $db = FDatabase::getInstance();
        list ($result, $rows_number) = $db->getLivello($livello);
        if (($result != null) && ($rows_number == 1)) {
            $utente = new EUtenteloggato($result['name'], $result['surname'], $result['email'], $result['password'], $result['state']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $utente = array();
                for ($i = 0; $i < count($result); $i++) {
                    $utente[] = new EUtenteloggato($result[$i]['name'], $result[$i]['surname'], $result[$i]['email'], $result[$i]['password'], $result[$i]['state']);
                }
            }
        }
        return $utente;


        /*    /**
             * Funzione che permette di modificare il livello
             * associato ad un certo account di un utente
             * @param int $idPren dela partita che vuole effettuare la modifica
             * @param string $liv numero di telefono
             * @return bool
             */
        /*    public static function UpdateLivello($idPren, $liv) {
                $field = "Livello";
                if (FPartita::update($idPren, $field, $liv)) return true;
                else return false;
            }

            /**
             * Funzione che permette di modificare il numero massimo di giocatori
             * associato ad un certa prenotazione
             * @param int $idPren dela partita che vuole effettuare la modifica
             * @param int $max numero massimo di giocatori
             * @return bool
             */
        /*    public static function UpdateNumeroMax($idPren, $num) {
                $field = "MaxNunGioc";
                if (FPartita::update($idPren, $field, $num)) return true;
                else return false;
            }

            /**
             * Funzione che permette di modificare la descrizione
             * di una certa partita associato ad una certa prenotazione
             * @param int $idPren della partita
             * @param string $not "nuova"
             * @return bool
             */

        /*    public static function UpdateNote($idPren, $not) {
                $field = "Note";
                if (FPartita::update($idPren, $field, $not)) return true;
                else return false;
            }

           /**
             * Funzione che permette di modificare una generico attributo della partita
             * @param int $idPart della partita che vuole effettuare la modifica
             * @param string $field campo da modificare
             * @param string $newvalue nuovo valore
             * @return bool
             */
        /*    public static function UpdateAccount($idPren, $field, $newvalue) {
                $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE id=" . $idPren . ";";
                $db = FDatabase::getInstance();
                if ($db->update($sql)) return true;
                else return false;
            }

            /**
             * Funzione che verifica l'esistenza di una partita
             * @param int $idPren della partita
             * @return object $part
             */
        /*    public static function ExistAccount($idPren) {
                $sql = "SELECT * FROM " . static::getTables() . " WHERE username='" . $idPren. "';";
                $db = FDatabase::getInstance();
                $result = $db->exist($sql);
                if ($result != null) {
                    $part = new EPartita($result['idPren'], $result['MaxNumGioc'], $result['Livello'], $result['Note']);
                    return $part;
                } else return null;
            }
            /**
             * Istanzia l'oggetto Partita dai risultati della query.
             * @param row tupla restituita dal dbms
             * @return l'oggetto partita
             */
        /*    public function createObjectFromRow($row) {
                $part = new EPartita();           //costruisce l'oggetto della classe EPartita
                $part->setNumeroMax($row['MaxNumGioc']);
                $part->setLivello($row['Livello']);
                $part->setNote($row['Note']);
                return $part;
            }
        */

    }
}
?>