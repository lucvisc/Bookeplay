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
    private static $tables = "giorno (`Giorno`,`FasciaOraria`)";
    /**
     * valori della tabella
     */
    private static $values = "(:Giorno,:FasciaOraria)";

    public function __construct(){}

    /**
     * Questo metodo lega gli attributi del giorno da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EGiorno $gg giorno i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EGiorno $gg)
    {
        $stmt->bindValue(':Giorno', $gg->getGiorno(), PDO::PARAM_STR);
        $stmt->bindValue(':FasciaOraria', $gg->getFasceOrarie(), PDO::PARAM_STR); //ricorda di "collegare" la giusta variabile al bind
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
    public static function store( EGiorno $giorno)
    {
        $db = FDatabase::getInstance();
        $id = $db->storeDB(static::getClass(), $giorno);
        return $id;
    }

    /**
     * Funzione che permette di poter reperire dal database eventuali istanze di oggetti che soddisfano i dati immessi
     * in input nella form di login. L'utente recuperato potà essere trasportatore, cliente o admin.
     * Viene ritornato l'utente utenteloggato/trasportatore/cliente
     * @param $giorno
     * @param $fasciaoraria
     * @return object|null
     */
    public static function loadGiorno($giorno, $fasciaoraria) {
        $gg = null;
        $db=FDatabase::getInstance();
        $result=$db->loadVerificaGiorno($giorno, $fasciaoraria);

        return $result;
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
            $giorno = new EGiorno($result['Giorno'], $result['FasciaOraria']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $giorno = array();
                for ($i = 0; $i < count($result); $i++) {
                    $giorno[] = new EGiorno($result[$i]['Giorno'], $result[$i]['FasciaOraria']);
                }
            }
        }
        return $giorno;
    }

    /**
     * Funzione che permette la load del giorno in base al paramentro giorno
     * @param string $gg del giorno di riferimento
     * @return object $gior
     */
    public static function loadGiornoFascia($field, $id)
    {
        $giorno = null;
        $db = FDatabase::getInstance();
        $result = $db->loadGiornoFascia(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if (($result != null) && ($rows_number == 1)) {
            $giorno = new EGiorno($result['Giorno'], $result['FasciaOraria']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $giorno = array();
                for ($i = 0; $i < count($result); $i++) {
                    $giorno[] = new EGiorno($result[$i]['Giorno'], $result[$i]['FasciaOraria']);
                }
            }
        }
        return $giorno;
    }

    /**
     * Questo metodo restistuisce un array contenente solo le fascie orarie disponibili di un determinato giorno
     * @param $giorno da analizzare
     * @return mixed
     */
    public static function loadGiorLib($giorno){
        $array=array(
            '09:00-10:00'=>'Disponibile',
            '10:00-11:00'=>'Disponibile',
            '11:00-12:00'=>'Disponibile',
            '12:00-13:00'=>'Disponibile',
            '14:00-15:00'=>'Disponibile',
            '15:00-16:00'=>'Disponibile',
            '16:00-17:00'=>'Disponibile',
            '17:00-18:00'=>'Disponibile',
            '18:00-19:00'=>'Disponibile',
            '20:00-21:00'=>'Disponibile',
            '21:00-22:00'=>'Disponibile');
        $fascia=self::loadGiornoFascia('Giorno', $giorno);
        $index=array_keys($array);
        if(isset($fascia)) {
            foreach ($fascia as $val) {
                for ($i = 0; $i <= (count($array) - 1); $i++) {
                    if ($index[$i] == $val->getFasceOrarie()) {
                        $array[$index[$i]] = 'Non Disponibile';
                    }
                }
            }
            $chiavi = array_keys($array);
            $i = 0;
            $j = 0;
            foreach ($array as $val) {
                if ($val == 'Disponibile') {
                    $result[$j] = $chiavi[$i];
                    $i++;
                    $j++;
                }
                else {
                    $i++;
                }
            }
        }
        else{
                $result=array_keys($array);
            }
        return $result;
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
        $result = $db->updateDBGiorno(static::getClass(), $field, $newvalue, $pk, $id);
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
            $giorno=new EGiorno($result['Giorno'],$result['FasciaOraria']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $giorno = array();
                for($i=0; $i<count($result); $i++){
                    $Giorno[]=new EGiorno($result[$i]['Giorno'],$result[$i]['FasciaOraria']);
                }
            }
        }
        return $giorno;
    }

}
?>