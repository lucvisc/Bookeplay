<?php
/**
 * La classe FPren_partecipa associa l'id della prenotazione all'id del account che sta partecipando alla prenotazione
 * @author Luca,Catriel
 * @package Foundation
 */
require_once 'include.php';

class FPren_partecipa {
    /**
     * classe foundation
     */
    private static $class = "FPren_partecipa";
    /**
     * tabella di riferimento su database
     */
    private static $table = "pren_partecipa (`idPren`,`email`);";
    /**
     * valori della tabella
     */
    private static $values = "(:idPren,:email)";

    /**
     * FPren_creata construct
     */
    public function __construct(){}

    /**
     * questo metodo restituisce il nome della classe per la costruzione delle Query
     * @return string $class nome della classe
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     * questo metodo restituisce il nome della tabella per la costruzione delle Query
     * @return string $table nome della tabella
     */
    public static function getTables(){
        return self::$table;
    }

    /**
     * questo metodo restituisce l'insieme dei valori per la costruzione delle Query
     * @return string $values nomi delle colonne della tabella
     */
    public static function getValues(){
        return self::$values;
    }




    /**
     * Metodo che permette di inserire un partecipante ad una prenotazione nel database
     * @param $idPren, id della prenotazione
     * @param $email, id dell'account che sta partecipando alla prenotazione
     * @return false|PDOStatement|null
     */
    static function insert ($idPren , $email) {
        $db = FDatabase::getInstance();
        $id = $db->insertPren_partecipa($idPren, $email);
        return $id;
    }

    /**
     * Metodo che permette di reperire un istanza di FPren_partecipa per testare se un utente puo o meno prenotarsi
     * se gia presente non può, altrimenti si può procedere
     * @param $idPren, id della prenotazione
     * @param $email, id dell'account che sta partecipando alla prenotazione
     * @return false|PDOStatement|null
     */
    static function loadVerificaPrenotazione ($idPren , $email) {
        $db = FDatabase::getInstance();
        $id = $db->loadVerificaPrenotazione($idPren, $email);
        return $id;
    }

    /**
     * Metodo che permette di poter reperire istanze dal database
     * @param $field nome del campo sul quale effettuare la ricerca
     * @param $id valore del campo che si vuole ricercare
     * @return array|mixed|null
     */
    public static function loadByField($field, $id){
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $field, $id);
        return ($result);
    }

    /**
     * Metodo che permette di ritornare il numero di partecipanti per una prenotazione
     * @param $giorno
     * @return object $username Account
     */
    public static function CountPartecipanti($id){
        $db=FDatabase::getInstance();
        $result=$db->CountPartecipanti($id);
        return $result;
    }


    /**
     * Metodo che permette di ritornare tutti partecipanti di una specifica prenotazione
     * @param $giorno
     * @return object $username Account
     */
    public static function loadPrenPart($id){
        $db=FDatabase::getInstance();
        $result=$db->getPrenotazionePartecipa($id);
        return $result;
    }

    /**
     * Metodo che permette contare quanti partecipanti ci sono in una specifica prenotazione
     * @param $giorno
     * @return object $username Account
     */
    public static function countPrenPart($id){
        $db=FDatabase::getInstance();
        $result=$db->getCountPartecipa($id);
        return $result;
    }






}
?>