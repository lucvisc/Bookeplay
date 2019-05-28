<?php


/**
 * La classe FUtente fornisce query per gli oggetti EUser
 * @author Luca, Catriel
 * @package Foundation
 */

class FAccount extends FDatabase
{

    private static $tables = "Account";
    private static $values = "(:idbooking,:quota,:giornobooking,:partita,:giornobooking)";


    public static function getTables()
    {
        return static::$tables;
    }

    /**
     *
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */

    public static function getValues()
    {
        return static::$values;
    }

    public static function bind($stmt, EBooking $booking)
    {
        $stmt->bindValue(':idbooking',NULL, PDO::PARAM_INT);
        $stmt->bindValue(':quota', $booking->getQuota(), PDO::PARAM_STR);
        $stmt->bindValue(':giornobooking', $booking->getPartecipanti(), PDO::PARAM_STR);
        $stmt->bindValue(':partita', $booking->getPartita(), PDO::PARAM_STR);
        $stmt->bindValue(':giornobooking', $booking->getGiornobooking(), PDO::PARAM_STR);
    }


    public static function storeBooking($booking)
    {
        $sql = "INSERT INTO " . static::getTables() . " VALUES " . static::getValues();
        $db = FDatabase::getInstance();
        $id = $db->store($sql, "FAccount", $booking);
        if ($id) return $id;
        else return null;
    }

    public static function loadBookingById($idbooking)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE id=" . $idbooking . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking = new EBooking($result['idbooking'], $result['quota'], $result['giornobooking'], $result['partita'], $result['giornobooking']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }

    /**
     * Funzione ch permette la load dell'utente in base all'username
     * @param string $comune dell'user di riferimento
     * @return object $user
     */

    public static function loadBookingByGiorno($giornobooking)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE giorno='" . $giornobooking . "';";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking =  $booking = new EBooking($result['idbooking'], $result['quota'], $result['giornobooking'], $result['partita'], $result['giornobooking']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }


    /**
     * Funzione ch permette la load dell'utente in base al paramentro id
     * @param int $id dell'user
     * @return object $user
     */
    public static function loadAccountByEmail($email)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE Email=" . $email . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking = new EBooking($result['idbooking'], $result['quota'], $result['giornobooking'], $result['partita'], $result['giornobooking']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }

    /**
     * Metodo che restituisce un determinato oggetto di tipo EBooking dal db in base alla fascia di prenotazione
     * @param $fascia è la fascia oraria di partenza
     * @return EBooking|null
     */
    public static function loadByFascia($fascia)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE fascia>=" . $fascia . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $booking = new EBooking($result['idbooking'], $result['quota'], $result['giornobooking'], $result['partita'], $result['giornobooking']);
            $booking->setId($result['id']);
            return $booking;
        } else return null;
    }

    /**
     * Funzione che permette la delete dell'utente in base all'id
     * @param int $id dell'utente che si vuole eliminare
     * @return bool
     */

    public static function deleteBooking($id)
    {
        $sql = "DELETE FROM " . static::getTables() . " WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }


    /**
     * Funzione che permette di modificare una generico attributo dell'utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */

    public static function UpdateBooking($id, $field, $newvalue)
    {
        $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->update($sql)) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto Address dai risultati dlella query.
     * @param string $row restituita dal dmbs
     * @return EAddress|obj
     */
    static function createObjectFromRow($row)
    {
        $booking = new Ebooking(); //costruisce l'istanza dell'oggetto
        $booking->setIdbooking($row['$idbooking']);
        $booking->setPartecipanti($row['password']);
        $booking->setPartita($row['email']);
        $booking->setDatebooking($row['telnumber']);
        $booking->setQuota($row['descrizione']);
        $booking->setTimebooking($row['conto']);
        $booking->setActivate($row['activate']);

        return $booking;
    }
}


