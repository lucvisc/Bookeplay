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
    private static $values="(:mail,:name,:surname,:dataNascita,:gender,:tipo)";

    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'user da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EUser $user i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt,EUser $user){
        $stmt->bindValue(':mail', $user->getID(), PDO::PARAM_STR);// l'id è posto a NULL poiché viene assegnato automaticamente
        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':surname', $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindValue(':dataNascita', $user->getDatanasc(), PDO::PARAM_STR);
        $stmt->bindValue(':gender', $user->getGender(), PDO::PARAM_STR);
        $stmt->bindValue(':tipo', "registrato", PDO::PARAM_STR);

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
        if(($result!=null) && ($rows_number == 1)) {        //':idAcc',':name',':surname',':dataNascita',':gender',':tipo'
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
     * Permette la load sul db
     * @param int l'id dell'oggetto indirizzo
     * @return object $address indirizzo
     */
    public static function loadByIdAccount($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE idAcc=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadsingle($sql);
        if($result!=null){
            $us=new EUser($result['idAcc'], $result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
            $us->setId($result['id']);
            return $us;
        }
        else return null;
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

    /**
     * Funzione che permette di poter reperire dal database eventuali istanze di oggetti che soddisfano i dati immessi
     * in input nella form di login. L'utente recuperato potrà essere utente e admin.
     * Viene ritornato l'utente utente/admin
     * @param $email valore dell'email immessa
     * @param $pass valore della password immessa
     * @return object|null utente/admin
     */
    public static function loadLogin ($email, $pass) {
    $utente = null;
    $db=FDatabase::getInstance();
    $result=$db->loadVerificaAccesso($email, $pass);

         if (isset($result)){
            $tra = FUser::loadByField("email" , $result["email"]);
            $admin = static::loadByField("email", $result["email"]);
            if ($tra)
            $utente = $tra;
            elseif ($admin)
            $utente = $admin;
         }

    return $utente;
    }


    /**
     * Metodo che  permette di ritornare gli utenti del db, filtrandoli attraverso una stringa in input,
     * la quale può contenere solo il nome, solo il cognome o nome e cognome dell'utente interessato
     * @param $string valore inserito nella barra di ricerca dell'admin
     * @return object|null $utente Utenteloggato
     */
    public static function loadUtentiByString($string){
        $utente = null;
        $toSearch = null;
        // attraverso gli spazi divido le parole immesse nella barra di ricerca
        $pieces = explode(" ", $string);
        // prendo l'ultimo elemento dell'array e se questo coincide con il primo elemento, so che devo cercare il match
        // o solo con il nome o solo con il cognome
        $lastElement = end($pieces);
        if ($pieces[0] == $lastElement) {
            $toSearch = 'nome';
        }
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->utentiByString($pieces, $toSearch);
        if(($result!=null) && ($rows_number == 1)) {
            $utente= new EUser($result['idAcc'],$result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
                for($i=0; $i<count($result); $i++){
                    $utente[]=new EUser($result['idAcc'],$result['name'], $result['surname'], $result['dataNascita'],$result['gender'],$result['tipo']);
                }
            }
        }
        return $utente;
    }


}
?>