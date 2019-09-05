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
    private static $tables = "prenotazione (`Quota`,`livello`,`Giorno`,`FasciaOraria`,`note`,`organizzatore`)";
    /**
     * campi della tabella
     */

    private static $values = "(:quota,:livello,:giorno,:fasciaOraria,:note, :organizzatore)";


    public function __construct(){}

    /**
     * Questo metodo lega gli attributi della classe booking da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EBooking $book prenotazione i cui dati devono essere inseriti nel DB
     */

    public static function bind($stmt, EBooking $booking)
    {
        //l'id è posto a NULL perche viene incrementato automaticamente dal DB
        $stmt->bindValue(':quota', $booking->getQuota(), PDO::PARAM_STR);
        $stmt->bindValue(':livello', $booking->getLivello(), PDO::PARAM_STR);
        $stmt->bindValue(':giorno', $booking->getGiornobooking()->getGiorno(), PDO::PARAM_STR);
        $stmt->bindValue(':fasciaOraria', $booking->getFascia(), PDO::PARAM_STR);
        $stmt->bindValue(':note', $booking->getNote(), PDO::PARAM_STR);
        $stmt->bindValue(':organizzatore', $booking->getOrganizzatore(), PDO::PARAM_STR);

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
    public static function store(EBooking $boo) // viene storizzato prima L'oggetto giorno perchè sarà poi foreign key di prenotazione
    {
        print_r($boo);
        $db=FDatabase::getInstance();
        FGiorno::store($boo->getGiornobooking());
        $id=$db->storeDB(static::getClass() ,$boo);
        $boo->setIdbooking($id);//siccome idBooking è autoincrementate viene inserito nell'oggetto passato solo dopo lo store e quindi la creazione del suo id
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
        if(($result!=null) && ($rows_number == 1)) {
            $boo[]=new EBooking($result['idP'], $result['livello'], $result['Giorno'],  $result['FasciaOraria'], $result['note'],  FPren_partecipa::loadPrenPart($result['idP']), $result['organizzatore']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                    $boo[]=new EBooking($result[$i]['idP'], $result[$i]['livello'], $result[$i]['Giorno'],  $result[$i]['FasciaOraria'], $result[$i]['note'], FPren_partecipa::loadPrenPart($result[$i]['idP']), $result[$i]['organizzatore']);
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
    public static function LoadBooking( string $giorno){
        $boo=null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->getbooking($giorno);
        if(($result!=null) && ($rows_number == 1)) {        //:idbooking,:quota,:giornobooking,:partita,:giornobooking
            $boo[]=new EBooking($result['idP'], $result['livello'], $result['Giorno'], $result['FasciaOraria'],  $result['note'], FPren_partecipa::loadPrenPart($result['idP']), $result['organizzatore']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                    $boo[]=new EBooking($result[$i]['idP'], $result[$i]['livello'], $result[$i]['Giorno'], $result[$i]['FasciaOraria'],  $result[$i]['note'], FPren_partecipa::loadPrenPart($result[$i]['idP']), $result[$i]['organizzatore']);
                }
            }
        }
        return $boo;
    }

    /**
     * Metodo per restituire tutte le prenotazione a cui ha partecipato un determinato utente
     * @param $email di riferimento
     * @return array|EBooking|null
     */
    public static function riepilogoPrenotazione($email){
        $boo = null;
        $db=FDatabase::getInstance();
        $result=$db->Riepilogo($email);
        $rows_number = $db->interestedRows('FPren_partecipa', 'email', $email);//funzione richiamata,presente in FDatabase

        if(($result!=null) && ($rows_number == 1)) {
            $boo[]=new EBooking($result['idP'], $result['livello'], $result['Giorno'],  $result['FasciaOraria'], $result['note'],null, $result['organizzatore']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $boo = array();
                for($i=0; $i<count($result); $i++){
                    $boo[]=new EBooking($result[$i]['idP'], $result[$i]['livello'], $result[$i]['Giorno'],  $result[$i]['FasciaOraria'], $result[$i]['note'], null, $result['organizzatore']);
                }
            }
        }
        return $boo;
    }

    /**
     * Funzione che permette di poter reperire dal database eventuali istanze di oggetti che soddisfano i dati immessi
     * in input nella form di login. L'utente recuperato potà essere trasportatore, cliente o admin.
     * Viene ritornato l'utente utenteloggato/trasportatore/cliente
     * @param $giorno
     * @param $fasciaoraria
     * @return object|null
     */
    public static function loadPrenotazioneEff($giorno, $fasciaoraria) {
        $gg = null;
        $db=FDatabase::getInstance();
        $result=$db->loadPrenotazioneEff($giorno, $fasciaoraria);
        return $result;
    }

}
?>

