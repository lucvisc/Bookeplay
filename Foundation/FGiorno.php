<?php

/**
 * La classe FGiorno fornisce query per gli oggetti EGiorno
 * @author Luca, Catriel
 * @package Foundation
 */
require_once 'include.php';

class FGiorno extends FDatabase {

    private static $tables = "Giorno";
    private static $values = "(:Giorno,:idFasciaOraria)";

    public function __construct() {}

    /**
     * Questo metodo lega gli attributi del giorno da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EGiorno $gg giorno i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EGiorno $gg) {
        $stmt->bindValue(':Giorno', $gg->getGiorno(), PDO::PARAM_STR);
        $stmt->bindValue(':idFasciaOraria', $gg->getFasceOrarie(), PDO::PARAM_STR); //ricorda di "collegare" la giusta variabile al bind
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
     * Funzione ch permette lo store dei dati di giorno in base al parametro giorno
     * @param string $giorno del giorno di riferimento
     * @return object $gg
     */
    public static function storeGiorno($gg) {
        $sql = "INSERT INTO " . static::getTables() . " VALUES " . static::getValues();
        $db = FDatabase::getInstance();
        $id = $db->store($sql, "FGiorno", $gg);
        if ($id) return $id;
        else return null;
    }

    /**
     * Funzione che permette la load del giorno in base al paramentro giorno
     * @param string $gg del giorno di riferimento
     * @return object $gior
     */
    public static function loadByGiorno($gg) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE Giorno=" . $gg . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $gior = new EGiorno($result['Giorno'], $result['idFasciaOraria']);
            $gior->setGiorno($result['Giorno']);
            return $gior;
        } else return null;
    }

    /**
     * Funzione che permette la delete dell'account in base all'id
     * @param int $id dell'account che si vuole eliminare
     * @return bool
     */
    public static function deleteGiorno($gg) {
        $sql = "DELETE FROM " . static::getTables() . " WHERE Giorno=" . $gg . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare le fasce orarie
     * associato ad un certo giorno di un utente
     * @param string $gg del giorno che si vuole effettuare la modifica
     * @param string $fasceorarie
     * @return bool
     */
    public static function UpdateFasceOrarie($gg, $fasce) {
        $field = "fasceorarie";
        if (FGiorno::update($gg, $field, $fasce)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare una generico attributo del giorno
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore
     * @return bool
     */

    public static function UpdateGiorno($gg, $field, $newvalue) {
        $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE Giorno=" . $gg . ";";
        $db = FDatabase::getInstance();
        if ($db->update($sql)) return true;
        else return false;
    }

    /**
     * Funzione che verifica l'esistenza di un giorno
     * @param string $gg
     * @return object $gior
     */
    public static function ExistGiorno($gg) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE Giorno='" . $gg . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) {
            $gior = new EGiorno($result['Giorno'], $result['idFasceOrarie']);
            $gior->setGiorno($result['Giorno']);
            return $gior;
        } else return null;
    }

    /**
     * Istanzia l'oggetto Giorno dai risultati della query.
     * @param row tupla restituita dal dbms
     * @return l'oggetto giorno
     */
    public function createObjectFromRow($row)
    {
        $gior = new EGiorno();              //costruisce l'oggetto della classe EAccount
        $gior->setGiorno($row['giorno']);
        $gior->getFasceOrarie($row['idFasceOrarie']);

        return $gior;
    }

}
?>