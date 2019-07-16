<?php

require_once 'include.php';

/**
 * La classe FUser fornisce query per gli oggetti EUser
 * @author Luca, Catriel
 * @package Foundation
 */

class FUser {

    private static $class="FUser";
    /**
     * tabella su cui opera
     */
    private static $tables="utente";
    /**
     * Valori della tabella
     */
    private static $values="(:idAcc,:name,:surname,:dataNascita,:gender,:tipo)";

    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'user da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EUser $user i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt,EUser $user){
        $stmt->bindValue(':idAcc', NULL, PDO::PARAM_INT);// l'id è posto a NULL poiché viene assegnato automaticamente
                                                                                // dal DBMS tramite (AUTOINCREMENT_ID)
        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':surname', $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindValue(':dataNascita', $user->getDatanasc(), PDO::PARAM_STR);
        $stmt->bindValue(':gender', $user->getGender(), PDO::PARAM_STR);
        $stmt->bindValue(':tipo', "User", PDO::PARAM_STR);
    }
    /**
     * questo metodo restituisce il nome della classe per la costruzione delle Query
     * @return string $class nome della classe
     */
    public static function getClass(){
        return self::$class;
    }


    /**
     *
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables(){
        return self::$tables;
    }

    /**
     *
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getValues(){
        return self::$values;
    }

    /**
     * Metodo che permette la store di uno user
     * @param $us User da salvare
     */
    public static function store($us)
    {
        $db=FDatabase::getInstance();
        $id=$db->storeDB(static::getClass() ,$us);
    }

    /**
     * Permette la load sul db
     * @param $id valore da confrontare per trovare l'oggetto
     * @param $field campo nel quale effettuare la ricerca
     * @return object $us User
     */
    public static function loadByField($field, $id){
        $us = null;
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if(($result!=null) && ($rows_number == 1)) {        //:idAcc,:name,:surname,:dataNascita,:gender,:tipo
            $us=new EUser($result['idAcc'], $result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $us = array();
                for($i=0; $i<count($result); $i++){
                    $us=new EUser($result['idAcc'],$result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
                }
            }
        }
        return $us;
    }

    /**
     * Funzione che permette di verificare se esiste un account nel database
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
     * Metodo che permette di ritornare lo user con quel idaccount presenti sul db
     * @param $giorno
     * @return object $user User
     */
    public static function loadUser($idacc){
        $us=null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->getUser($idacc);
        if(($result!=null) && ($rows_number == 1)) {        //:idAcc,:name,:surname,:dataNascita,:gender,:tipo
            $us=new EUser($result['idAcc'],$result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $us = array();
                for($i=0; $i<count($result); $i++){
                    $us=new EUser($result['idAcc'],$result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
                }
            }
        }
        return $us;
    }

    /*/**
     * Funzione ch permette la load dell'utente in base al paramentro id
     * @param int $id dell'user
     * @return object $user
     */
    /*public static function loadById($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $user=new EUser($result['idAcc'],$result['name'], $result['surname'],$result['dataNascita'],$result['gender'], $result['tipo']);
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
   /* public static function loadByUsername($username){
        $sql=cercaUtenteByUsername();
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $user=new EUser($result['idAcc'],$result['name'], $result['surname'],$result['dataNascita'],$result['gender'], $result['tipo']);
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
   /* public static function deleteUser($id){
        $sql="DELETE FROM ".static::getTables()." WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        if($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare la data di nascita
     * di un certo utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param date $dataNa data di nascita "nuova"
     * @return bool
     */
   /* public static function UpdateDatanascita($id,$dataNa){
        $field="dataNascita";
        if(FUser::update($id,$field,$dataNa)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare una generico attributo dell'utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */
   /* public static function UpdateUser($id,$field,$newvalue){
        $sql="UPDATE ".static::getTables()." SET ".$field."='".$newvalue."' WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        if($db->update($sql)) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto utente dai risultati della query.
     * @param row tupla restituita dal dbms
     * @return l'oggetto utente
     */
    /*public function createObjectFromRow($row)
    {
        $utente = new EUser(); //costruisce l'istanza dell'oggetto
        $utente->setName($row['name']);
        $utente->setSurname($row['surname']);
        $utente->setDatanasc($row['datanasc']);
        $utente->setGender($row['gender']);
        //$utente->setAddress($row['address']);
       // $utente->setAccount($row['account']);

        return $utente;
    }*/
}
?>