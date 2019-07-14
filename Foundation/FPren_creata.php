<?php
/**
* La classe FPren_creata associa l'id della prenotazione all'id del account che ha effettuato la prenotazione
* @author Luca,Catriel
* @package Foundation
*/

class FPren_creata {
    /**
     * classe foundation
     */
    private static $class = "FPren_creata";
    /**
     * tabella di riferimento su database
     */
    private static $table = "pren_creata";
    /**
     * valori della tabella
     */
    private static $values = "(:idPren,:idAcc)";

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
     * @param $idPren, id della prenotazione creata
     * @param $idAcc, id dell'account che ha effettuato la prenotazione
     * @return false|PDOStatement|null
     */
    static function insert ($idPren , $idAcc) {
        $db = FDatabase::getInstance();
        $id = $db->insertPren_creata($idPren, $idAcc);
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