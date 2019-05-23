<?php

//require_once 'include.php';

/**
 * La classe FUser fornisce query per gli oggetti EUser
 * @author Luca, Catriel
 * @package Foundation
 */

class FUser extends FDatabase {
    private static $tables="utenti";
    private static $values="(:name,:surname,:gender,:datanasc,:address,:account)";

    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'user da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EUser $user i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt,EUser $user){
        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':surname', $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindValue(':datanasc', $user->getDatanasc(), PDO::PARAM_STR);
        $stmt->bindValue(':gender', $user->getGender(), PDO::PARAM_STR);
        $stmt->bindValue(':address', $user->getAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':account', $user->getAccount(), PDO::PARAM_STR);
    }
    /**
     *
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */

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


    public static function storeUser($user){
        $sql="INSERT INTO ".static::getTables()." VALUES ".static::getValues();
        $db=FDatabase::getInstance();
        $id=$db->store($sql,"FUser",$user);
        if($id) return $id;
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
            $user=new EUser($result['name'], $result['surname'],$result['gender'],$result['address'], $result['account']);
            $user->setId($result['id']);
            return $user;
        }
        else return null;
    }

    /**
     * Funzione ch permette la load dell'utente in base all'username
     * @param string $username dell'user di riferimento
     * @return object $user
     */

    public static function loadByUsername($username){
        $sql="SELECT * FROM ".static::getTables()." WHERE username='".$username."';";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $user=new EUser($result['name'], $result['surname'],$result['gender'],$result['address'], $result['account']);
            $user->setId($result['id']);
            return $user;
        }
        else return null;
    }

    /**
     * Funzione che permette la delete dell'utente in base all'id
     * @param int $id dell'utente che si vuole eliminare
     * @return bool
     */

    public static function deleteUser($id){
        $sql="DELETE FROM ".static::getTables()." WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        if($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare la data di nascita
     * di un certo utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param date $datan data di nascita "nuova"
     * @return bool
     */


    public static function UpdateDatan($id,$datan){
        $field="datan";
        if(FUser::update($id,$field,$datan)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare una generico attributo dell'utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */

    public static function UpdateUser($id,$field,$newvalue){
        $sql="UPDATE ".static::getTables()." SET ".$field."='".$newvalue."' WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        if($db->update($sql)) return true;
        else return false;
    }
    /**
     * Query che restituisce gli utenti in base al nome
     * @return string la query sql
     */
    static function cercaUtenteByUsername() : string
    {
        return "SELECT *
                FROM utenti
                WHERE LOCATE( :username , username) > 0;";
    }

    /**
     * Istanzia l'oggetto utente dai risultati della query.
     * @param row tupla restituita dal dbms
     * @return l'oggetto utente
     */
    static function createObjectFromRow($row)
    {
        $utente = new EUser(); //costruisce l'istanza dell'oggetto
        $utente->setName($row['name']);
        $utente->setSurname($row['surname']);
        $utente->setDatanasc($row['datanasc']);
        $utente->setGender($row['gender']);
        $utente->setAddress($row['address']);
        $utente->setAccount($row['account']);

        return $utente;
    }
}
?>