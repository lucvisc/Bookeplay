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

    private static $values = "(:idP,:quota,:livello,:note)";


    public function __construct(){}

    /**
     * Questo metodo lega gli attributi della classe booking da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EBooking $book prenotazione i cui dati devono essere inseriti nel DB
     */

    public static function bind($stmt, EBooking $booking)
    {
        $stmt->bindValue(':idP',NULL, PDO::PARAM_INT); //l'id è posto a NULL perche viene incrementato automaticamente dal DB
        $stmt->bindValue(':quota', $booking->getQuota(), PDO::PARAM_STR);
        $stmt->bindValue(':livello', $booking->getLivello(), PDO::PARAM_STR);
        $stmt->bindValue(':note', $booking->getNote(), PDO::PARAM_STR);
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
    public static function store(EBooking $boo) //, EGiorno $obj1, EPartita $obj2
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
            $boo=new EBooking($result['idP'],$result['quota'], $result['livello'], $result['note']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                    $boo=new EBooking($result['idP'],$result['quota'], $result['livello'], $result['note']);
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
            $boo=new EBooking($result['idP'],$result['quota'], $result['livello'], $result['note']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                    $boo=new EBooking($result['idP'],$result['quota'], $result['livello'], $result['note']);
                }
            }
        }
        return $boo;
    }

}
?>

