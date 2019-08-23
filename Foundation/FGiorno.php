<?php

/**
 * La classe FGiorno fornisce query per gli oggetti EGiorno
 * @author Luca, Catriel
 * @package Foundation
 */
require_once 'include.php';

class FGiorno {
    /**
     * classe foundation
     */
    private static $class = "FGiorno";
    /**
     * tabella di riferimento
     */
    private static $tables = "giorno";
    /**
     * valori della tabella
     */
    private static $values = "(:Giorno,:idFasciaOraria)";

    public function __construct(){}

    /**
     * Questo metodo lega gli attributi del giorno da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EGiorno $gg giorno i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EGiorno $gg)
    {
        $stmt->bindValue(':Giorno', $gg->getGiorno(), PDO::PARAM_STR);
        $stmt->bindValue(':idFasciaOraria', $gg->getFasceOrarie(), PDO::PARAM_STR); //ricorda di "collegare" la giusta variabile al bind
    }

    /**
     * questo metodo restituisce la classe della tabella sul DB per la costruzione delle Query
     * @return string $class classe della tabella di riferimento
     */
    public static function getClass()
    {
        return self::$class;
    }

    /**
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables()
    {
        return self::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */

    public static function getValues()
    {
        return self::$values;
    }

    /**
     * Funzione ch permette lo store dei dati di giorno in base al parametro giorno
     * @param string $giorno del giorno di riferimento
     * @return object $gg
     */
    public static function store($giorno)
    {
        $db = FDatabase::getInstance();
        $id = $db->storeDB(static::getClass(), $giorno);
    }

    /**
     * Funzione che permette la load del giorno in base al paramentro giorno
     * @param string $gg del giorno di riferimento
     * @return object $gior
     */
    public static function loadByField($field, $id)
    {
        $giorno = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if (($result != null) && ($rows_number == 1)) {
            $giorno = new EGiorno($result['giorno'], $result['idFasciaOraria']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $giorno = array();
                for ($i = 0; $i < count($result); $i++) {
                    $giorno[] = new EGiorno($result[$i]['giorno'], $result[$i]['idFasciaOraria']);
                }
            }
        }
        return $giorno;
    }

    /**
     * Funzione che verifica l'esistenza di un giorno
     * @param  $id valore di cui verificare l'esistenza
     * @param $field colonna su ci eseguire la verifica
     * @return bool
     */
    public static function exist($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->existDB(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if ($result != null)
            return true;
        else
            return null;
    }

    /**
     * Metodo che aggiorna i campi di un Giorno
     * @param $field campo nel quale si vuole modificare il valore
     * @param $newvalue nuovo valore da assegnare
     * @param $pk nome della colonna utilizzata per l'espressione "where" della query
     * @param $id valore della primary key da usare come riferimento
     * @return true se esiste, altrimenti false
     */
    public static function update($field, $newvalue, $pk, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
        if ($result) return true;
        else return false;
    }

    /**
     * Permette la delete sul db in base all'id
     * @param $field nome del campo della tabella nel quale ricercare il valore immesso
     * @param $id valore del campo
     * @return bool
     */
    public static function delete($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->deleteDB(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
        if ($result)
            return true;
        else
            return false;
    }

    /**
     * Metodo che permette di ritornare tutti i giorni presenti sul db
     * @param $giorno
     * @return object $giorno Giorno
     */
    public static function loadGiorni($giorno){
        $giorno = null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->getGiorni($giorno);
        if(($result!=null) && ($rows_number == 1)) {        //:Giorno,:idFasciaOraria
            $giorno=new EGiorno($result['Giorno'],$result['idFasciaOraria']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $giorno = array();
                for($i=0; $i<count($result); $i++){
                    $Giorno[]=new EGiorno($result[$i]['Giorno'],$result[$i]['idFasciaOraria']);
                }
            }
        }
        return $giorno;
    }

}
?>