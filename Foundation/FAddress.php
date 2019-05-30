<?php

/**
 * La classe FAddress fornisce query per gli oggetti EAddress
 * @author Luca, Catriel
 * @package Foundation
 */
require_once '../include.php';

class FAddress extends FDatabase {

    private static $tables="Address";
    private static $values="(:idAcc,:Comune,:Provincia,:CAP,:Via,:NumCivico)";

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
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getTables(){
        return static::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getValues(){
        return static::$values;
    }

    public static function storeAddress($addr){
        $sql="INSERT INTO ".static::getTables()." VALUES ".static::getValues();
        $db=FDatabase::getInstance();
        $id=$db->store($sql,"FAddress",$addr);
        if($id) return $id;
        else return null;
    }

    public static function loadAddressById($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['Comune'], $result['Provincia'],$result['CAP'],$result['Via'], $result['NumCivico']);
            $addr->setId($result['idAcc']);
            return $addr;
        }
        else return null;
    }

    /**
     * Funzione ch permette la load dell comune
     * @param string $comune dell'user di riferimento
     * @return object $user
     */
    public static function loadByComune($comune){
        $sql="SELECT * FROM ".static::getTables()." WHERE Comune='".$comune."';";
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
     * Funzione ch permette la load dell'indirizzo in base al paramentro id
     * @param int $id dell'account che fa riferimento ad un utente
     * @return object $addr
     */
    public static function loadById($id){
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
    public static function deleteAddress($id){
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
    public static function UpdateAddress($id,$field,$newvalue){
        $sql="UPDATE ".static::getTables()." SET ".$field."='".$newvalue."' WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        if($db->update($sql)) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto Address dai risultati dlella query.
     * @param string $row restituita dal dmbs
     * @return EAddress|obj
     */
    public function createObjectFromRow($row) {
        $indirizzo = new EAddress(); //costruisce l'istanza dell'oggetto
        $indirizzo->setComune($row['Comune']);
        $indirizzo->setProvincia($row['Provincia']);
        $indirizzo->setCap($row['CAP']);
        $indirizzo->setVia($row['Via']);
        $indirizzo->setNcivicos($row['NumCivico']);

        return $indirizzo;
    }
}
?>
