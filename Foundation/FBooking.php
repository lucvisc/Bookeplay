<?php
/**
 * La classe FBooking fornisce query per gli oggetti EBooking
 * @author Luca, Catriel
 * @package Foundation
 */

require_once 'include.php';


/**
 * La classe FUser fornisce query per gli oggetti EBooking
 * @author Luca, Catriel
 * @package Foundation
 */
class FBooking{

    /**
     * classe foundation
     */
    private static $class="FBooking";
    /**
     * @Tabella di riferimento
     */
    private static $tables = "prenotazione";
    /**
     * campi della tabella
     */
    private static $values = "(:idbooking,:quota,:giornobooking,:partita,:giornobooking)";


    public function __construct(){}

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
     * questo metodo restituisce il nome della classe sul DB per la costruzione delle Query
     * @return string $class classe della tabella di riferimento
     */
    public function getClass(){
        return self::$class;
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
     * Metodo che permette la store di una prenotazione
     * @param $boo prenotazione da salvare
     */
    public static function store($boo)
    {
        $db=FDatabase::getInstance();
        $id=$db->storeDB(static::getClass() ,$boo);
    }

    /**
     * Permette la load sul db
     * @param $id valore da confrontare per trovare l'oggetto
     * @param $field campo nel quale effettuare la ricerca
     * @return object $boo Booking
     */
    public static function loadByField($field, $id){
        $boo = null;
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if(($result!=null) && ($rows_number == 1)) {        //:idbooking,:quota,:giornobooking,:partita,:giornobooking
            $boo=new EBooking($result['idbooking'],$result['quota'], $result['giornobooking'], $result['partita'],$result['giornobooking']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                     $boo=new EBooking($result['idbooking'],$result['quota'], $result['giornobooking'], $result['partita'],$result['giornobooking']);
                }
            }
        }
        return $boo;
    }


    public static function exist($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->existDB(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if ($result != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Metodo che aggiorna i campi di un Address
     * @param $field campo nel quale si vuole modificare il valore
     * @param $newvalue nuovo valore da assegnare
     * @param $pk nome della colonna utilizzata per l'espressione "where" della query
     * @param $id valore della primary key da usare come riferimento
     * @return true se esiste il mezzo, altrimenti false
     */
    public static function update($field, $newvalue, $pk, $id){
        $db=FDatabase::getInstance();
        $result = $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
        if($result) return true;
        else return false;
    }

    /**
     * Permette la delete sul db in base all'id
     * @param $field nome del campo della tabella nel quale ricercare il valore immesso
     * @param $id valore del campo
     * @return bool
     */
    public static function delete($field, $id){
        $db=FDatabase::getInstance();
        $result = $db->deleteDB(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
        if($result) return true;
        else return false;
    }

    /**
     * Metodo che permette di ritornare tutte le prenotazioni da oggi
     * @param $giorno
     * @return object $username Account
     */
    public static function LoadBooking(){
        $boo=null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->getbooking();
        if(($result!=null) && ($rows_number == 1)) {        //:idbooking,:quota,:giornobooking,:partita,:giornobooking
            $boo=new EBooking($result['idbooking'],$result['quota'], $result['giornobooking'], $result['partita'],$result['giornobooking']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                    $boo=new EBooking($result['idbooking'],$result['quota'], $result['giornobooking'], $result['partita'],$result['giornobooking']);
                }
            }
        }
        return $boo;
    }







/////////OLD SCRIPT///////////





    /*/**
     * Funzione ch permette la load della prenotazione in base al paramentro id
     * @param int $id della prenotazione di riferimento
     * @return object $idbooking
     */
   /* public static function loadBookingById($idbooking) {
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
   /* public static function loadBookingByGiorno($giornobooking) {
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
   /* public static function loadByFascia($fascia) {
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
   /* public static function deleteBooking($id) {
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
   /* public static function UpdateBooking($id, $field, $newvalue) {
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
   /* public function createObjectFromRow($row) {
        $booking = new Ebooking(); //costruisce l'istanza dell'oggetto
        $booking->setGiornobooking($row['giornobooking']);
        $booking->setQuota($row['quota']);
        $booking->setPartecipanti($row['partecipanti']);
        $booking->setPartita($row['partita']);
        return $booking;
    }  */
}
?>

