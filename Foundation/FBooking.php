<?php
/**
 * La classe FBooking fornisce query per gli oggetti EBooking
 * @author Luca, Catriel
 * @package Foundation
 */

class FAccount extends FDatabase
{

    private static $tables = "Account";
    private static $values = "(:idbooking,:quota,:giornobooking,:partita,:giornobooking)";

    /**
     * Questo metodo lega gli attributi della classe booking da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EBooking $book prenotazione i cui dati devono essere inseriti nel DB
     */

    public static function bind($stmt, EBooking $booking)
    {
        $stmt->bindValue(':idbooking',NULL, PDO::PARAM_INT); //l'id è posto a NULL perche viene incrementato automaticamente dal DB
        $stmt->bindValue(':giornobooking', $booking->getGiornobooking(), PDO::PARAM_STR);
        $stmt->bindValue(':quota', $booking->getQuota(), PDO::PARAM_STR);
        $stmt->bindValue(':partecipanti', $booking->getPartecipanti(), PDO::PARAM_STR);
        $stmt->bindValue(':partita', $booking->getPartita(), PDO::PARAM_STR);
    }

    /**
     *
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables() {
        return static::$tables;
    }

    /**
     *
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getValues() {
        return static::$values;
    }

    /**
     * Funzione ch permette lo store dei dati di booking in base al parametro id
     * @param int $id della prenotazione di riferimento
     * @return object $booking
     */
    public static function storeBooking($booking) {
        $sql = "INSERT INTO " . static::getTables() . " VALUES " . static::getValues();
        $db = FDatabase::getInstance();
        $id = $db->store($sql, "FBooking", $booking);
        if ($id) return $id;
        else return null;
    }

    /**
     * Funzione ch permette la load della prenotazione in base al paramentro id
     * @param int $id della prenotazione di riferimento
     * @return object $idbooking
     */
    public static function loadBookingById($idbooking) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE id=" . $idbooking . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking = new EBooking($result['idbooking'], $result['giornobooking'], $result['quota'], $result['partecipanti'], $result['partita']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }

    /**
     * Funzione che permette la load della prenotazione in base al giorno
     * @param string $giornobooking della prenotazione di riferimento
     * @return object $giornobooking
     */
    public static function loadBookingByGiorno($giornobooking) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE giorno='" . $giornobooking . "';";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking = new EBooking($result['idbooking'], $result['giornobooking'], $result['quota'], $result['partecipanti'], $result['partita']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }

    /**
     * Metodo che restituisce un determinato oggetto di tipo EBooking dal db in base alla fascia di prenotazione
     * @param $fascia è la fascia oraria di partenza
     * @return EBooking|null
     */
    public static function loadByFascia($fascia) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE fascia>=" . $fascia . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking = new EBooking($result['idbooking'], $result['giornobooking'], $result['quota'], $result['partecipanti'], $result['partita']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }

    /**
     * Funzione che permette la delete della prenotazione in base all'id
     * @param int $id dell'utente che si vuole eliminare
     * @return bool
     */
    public static function deleteBooking($id) {
        $sql = "DELETE FROM " . static::getTables() . " WHERE idP=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare una generico attributo della prenotazione
     * @param int $id della prenotazione che si vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */
    public static function UpdateBooking($id, $field, $newvalue) {
        $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE idP=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->update($sql)) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto Booking dai risultati della query.
     * @param string $row restituita dal dmbs
     * @return EBooking|obj
     */
    static function createObjectFromRow($row) {
        $booking = new Ebooking(); //costruisce l'istanza dell'oggetto
        $booking->setGiornobooking($row['giornobooking']);
        $booking->setQuota($row['quota']);
        $booking->setPartecipanti($row['partecipanti']);
        $booking->setPartita($row['partita']);

        return $booking;
    }
}


