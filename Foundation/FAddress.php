<?php

/**
 * La classe FAddress fornisce query per gli oggetti EAddress
 * @author Luca, Catriel
 * @package Foundation
 */
require_once 'include.php';

class FAddress {
    /**
     * classe foundation
     */
    private static $class="FAddress";
    /**
     * tabella di riferimento
     */
    private static $tables="Address";
    /**
     * valori della tabella
     */
    private static $values="(:idAcc,:Comune,:Provincia,:CAP,:Via,:NumCivico)";

    public function __construct(){}

    public static function bind($stmt, EAddress $addr) {
        $stmt->bindValue(':idAcc', NULL, PDO::PARAM_INT);  // l'id è posto a NULL poiché viene assegnato automaticamente
                                                            // dal DBMS tramite (AUTOINCREMENT_ID)
        $stmt->bindValue(':Comune', $addr->getComune(), PDO::PARAM_STR);
        $stmt->bindValue(':Provincia', $addr->getProvincia(), PDO::PARAM_STR);
        $stmt->bindValue(':CAP', $addr->getCap(), PDO::PARAM_STR);
        $stmt->bindValue(':Via', $addr->getVia(), PDO::PARAM_STR);
        $stmt->bindValue(':NumCivico', $addr->getNcivico(), PDO::PARAM_STR);
    }
    /**
     * questo metodo restituisce il nome della classe sul DB per la costruzione delle Query
     * @return string $class classe della tabella di riferimento
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getTables(){
        return self::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getValues(){
        return self::$values;
    }

    /**
     * Metodo che permette la store di un Utenteloggato
     * @param $utente Utenteloggato da salvare
     */
    public static function store($address){
        $db=FDatabase::getInstance();
        $id=$db->storeDB(static::getClass() ,$address);
    }

    /**
     * Permette la load sul db
     * @param $id valore da confrontare per trovare l'oggetto
     * @param $field campo nel quale effettuare la ricerca
     * @return object $address Address
     */
    public static function loadByField($field, $id){
        $address = null;
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if(($result!=null) && ($rows_number == 1)) {        //:idAcc,:Comune,:Provincia,:CAP,:Via,:NumCivico
            $address=new EAddress($result['idAcc'],$result['Comune'], $result['Provincia'], $result['CAP'],$result['Via'],$result['NumCivico']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $address = array();
                for($i=0; $i<count($result); $i++){
                    $address[]=new EAddress($result[$i]['idAcc'],$result[$i]['Comune'], $result[$i]['Provincia'], $result[$i]['CAP'],$result[$i]['Via'],$result[$i]['NumCivico']);
                }
            }
        }
        return $address;
    }

    /**
     * Funzione che permette di verificare se esiste un indirizzo nel database
     * @param  $id valore di cui verificare la presenza
     * @param $field colonna su ci eseguire la verifica
     * @return bool
     */
    public static function exist($field, $id){
        $db=FDatabase::getInstance();
        $result=$db->existDB(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if($result!=null)
            return true;
        else
            return false;
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


/*
    /**
     * Funzione ch permette la load dell comune
     * @param string $comune dell'user di riferimento
     * @return object $user
     */
 /*   public static function loadByComune($comune){
        $sql="SELECT * FROM ".static::getTables()." WHERE Comune='".$comune."';";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){          //:idAcc,:Comune,:Provincia,:CAP,:Via,:NumCivico
            $addr=new EAddress($result['Comune'], $result['Provincia'],$result['CAP'],$result['Via'], $result['NumCivico']);
            $addr->setId($result['id']);
            return $addr;
        }
        else return null;
    }

    /**
     * Funzione ch permette la load dell'indirizzo in base al paramentro id
     * @param int $id dell'account che fa riferimento ad un utente
     * @return object $addr
     */
/*    public static function loadById($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['Comune'], $result['Provincia'],$result['CAP'],$result['Via'], $result['NumCivico']);
            $addr->setId($result['id']);
            return $addr;
        }
        else return null;
    }

    public static function loadByProvincia($provincia){
        $sql="SELECT * FROM ".static::getTables()." WHERE Provincia=".$provincia.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['Comune'], $result['Provincia'],$result['CAP'],$result['Via'], $result['NumCivico']);
            $addr->setId($result['id']);
            return $addr;
        }
        else return null;
    }

    /**
     * Funzione che permette la delete dell'utente in base all'id
     * @param int $id dell'utente che si vuole eliminare
     * @return bool
     */
 /*   public static function deleteAddress($id){
        $sql="DELETE FROM ".static::getTables()." WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        if($db->delete($sql)) return true;
        else return false;
    }


    /**
     * Funzione che permette di modificare una generico attributo dell'indirizzo
     * @param int $id identificativo dell'account a cui fa riferimento un utente che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */
 /*   public static function UpdateAddress($id,$field,$newvalue){
        $sql="UPDATE ".static::getTables()." SET ".$field."='".$newvalue."' WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        if($db->update($sql)) return true;
        else return false;
    }
 */

}
?>
