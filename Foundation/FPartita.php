<?php
require_once '../include.php';

/**
 * La classe FPartita fornisce query per gli oggetti EPartita
 * @author Luca, Catriel
 * @package Foundation
 */
class FPartita extends FDatabase
{
    private static $tables = "partita";
    private static $values = "(:idPren,:MaxNumGioc,:Livello,:Note)";

    public function __construct() {
    }

    /**
     * Questo metodo lega gli attributi della classe partita da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EPartita $par partita i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EPartita $par) {
        $stmt->bindValue(':idPren',NULL, PDO::PARAM_INT); //l'id è posto a NULL perche viene incrementato automaticamente dal DB
        $stmt->bindValue(':MaxNumGioc', $par->getNumMax(), PDO::PARAM_STR);
        $stmt->bindValue(':Livello', $par->getLivello(), PDO::PARAM_STR);
        $stmt->bindValue(':Note', $par->getNote(), PDO::PARAM_STR);
    }

    /**
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables() {
        return static::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */

    public static function getValues() {
        return static::$values;
    }

    /**
     * Funzione che permette la delete dell'account in base all'id
     * @param int $id dell'account che si vuole eliminare
     * @return bool
     */
    public static function deletePartita($id) {
        $sql = "DELETE FROM " . static::getTables() . " WHERE idPren=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare il livello
     * associato ad un certo account di un utente
     * @param int $idPren dela partita che vuole effettuare la modifica
     * @param string $liv numero di telefono
     * @return bool
     */
    public static function UpdateLivello($idPren, $liv) {
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
    public static function UpdateNumeroMax($idPren, $num) {
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

    public static function UpdateNote($idPren, $not) {
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
    public static function UpdateAccount($idPren, $field, $newvalue) {
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
    public static function ExistAccount($idPren) {
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
    public function createObjectFromRow($row) {
        $part = new EPartita();           //costruisce l'oggetto della classe EPartita
        $part->setNumeroMax($row['MaxNumGioc']);
        $part->setLivello($row['Livello']);
        $part->setNote($row['Note']);
        return $part;
    }

}

?>