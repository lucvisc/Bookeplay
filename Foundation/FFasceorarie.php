<?php
/**
 * La classe FFasceorarie è formata dalle fasce orarie disponibili per un determinato cliente
 * @author Luca,Catriel
 * @package Foundation
 */
require_once 'include.php';

class FFasceorarie {
    /**
     * classe foundation
     */
    private static $class = "FFasceorarie";
    /**
     * tabella di riferimento su database
     */
    private static $table = "fasceorarie";
    /**
     * valori della tabella
     */
    private static $values = "(:idFascia,:Fascia,:disp)";

    /**
     * FFasceorarie construct
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
    public static function getTable(){
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
     * Metodo che permette di inserire una nuova prenotazione nel database
     * @param $idPren, id della prenotazione
     * @param $idAcc, id dell'account che sta partecipando alla prenotazione
     * @return false|PDOStatement|null
     */
    static function insert ($idFascia , $Fascia, $disp) {
        $db = FDatabase::getInstance();
        $id = $db->insertFasceorarie($idFascia , $Fascia, $disp);
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

}
?>