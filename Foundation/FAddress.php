<?php

/**
 * La classe FUtente fornisce query per gli oggetti EUser
 * @author Luca, Catriel
 * @package Foundation
 */
require_once '../include.php';

class FAddress extends FDatabase {

private static $tables="Address";
private static $values="(:id,:username,:password,:comune,:provincia,:cap,:via,:ncivico)";


    public static function getTables(){
        return static::$tables;
    }

    /**
     *
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */

    public static function getValues(){
        return static::$values;
    }

 public static function bind($stmt, EAddress $addr)
{
    $stmt->bindValue(':comune', $addr->getComune(), PDO::PARAM_STR);
    $stmt->bindValue(':provincia', $addr->getProvincia(), PDO::PARAM_STR);
    $stmt->bindValue(':cap', $addr->getCap(), PDO::PARAM_STR);
    $stmt->bindValue(':via', $addr->getVia(), PDO::PARAM_STR);
    $stmt->bindValue(':nciv', $addr->getNcivico(), PDO::PARAM_STR);
}


    public static function storeAddress($addr){
        $sql="INSERT INTO ".static::getTables()." VALUES ".static::getValues();
        $db=FDatabase::getInstance();
        $id=$db->store($sql,"FAddress",$addr);
        if($id) return $id;
        else return null;
    }

    public static function loadAddressById($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['comune'], $result['provincia'],$result['cap'],$result['via'], $result['ncivico']);
            $addr->setId($result['id']);
            return $addr;
        }
        else return null;
    }

    /**
     * Funzione ch permette la load dell'utente in base all'username
     * @param string $comune dell'user di riferimento
     * @return object $user
     */

    public static function loadByComune($comune){
        $sql="SELECT * FROM ".static::getTables()." WHERE Comune='".$comune."';";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['comune'], $result['provincia'],$result['cap'],$result['via'], $result['ncivico']);
            $addr->setId($result['id']);
            return $addr;
        }
        else return null;
    }


    /**
     * Funzione ch permette la load dell'utente in base al paramentro id
     * @param int $id dell'user
     * @return object $user
     */
    public static function loadById($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['comune'], $result['provincia'],$result['cap'],$result['via'], $result['ncivico']);
            $addr->setId($result['id']);
            return $addr;
        }
        else return null;
    }


    public static function loadByProvincia($provincia){
        $sql="SELECT * FROM ".static::getTables()." WHERE provincia=".$provincia.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $addr=new EAddress($result['comune'], $result['provincia'],$result['cap'],$result['via'], $result['ncivico']);
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
        $sql="DELETE FROM ".static::getTables()." WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        if($db->delete($sql)) return true;
        else return false;
    }


    /**
     * Funzione che permette di modificare una generico attributo dell'utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */

    public static function UpdateAddress($id,$field,$newvalue){
        $sql="UPDATE ".static::getTables()." SET ".$field."='".$newvalue."' WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        if($db->update($sql)) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto Address dai risultati dlella query.
     * @param string $row restituita dal dmbs
     * @return EAddress|obj
     */
    public function createObjectFromRow($row)
    {
        $indirizzo = new EAddress(); //costruisce l'istanza dell'oggetto
        $indirizzo->setComune($row['comune']);
        $indirizzo->setProvincia($row['provincia']);
        $indirizzo->setCap($row['cap']);
        $indirizzo->setVia($row['via']);
        $indirizzo->setNcivicos($row['ncivico']);

        return $indirizzo;
    }
}

?>
