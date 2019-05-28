<?php
require_once 'include.php';
/**
 * La classe FAccount fornisce query per gli oggetti EAccount
 * @author Luca, Catriel
 * @package Foundation
 */
class FAccount extends FDatabase {
    private static $tables = "account";
    private static $values = "(:id,:username,:password,:email,:telnumber,:conto,:descrizione,:activate)";

    public function __construct(){
    }

    /**
     * Questo metodo lega gli attributi dell'account da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAccount $acc account i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EAccount $acc)
    {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);// l'id è posto a NULL poiché viene assegnato automaticament                                                                  // dal DBMS tramite (AUTOINCREMENT_ID)
        $stmt->bindValue(':username', $acc->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $acc->getPassword(), PDO::PARAM_STR); //ricorda di "collegare" la giusta variabile al bind
        $stmt->bindValue(':email', $acc->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':conto', $acc->getConto(), PDO::PARAM_STR);
        $stmt->bindValue(':telnumber', $acc->getTelnumber(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $acc->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':activate', $acc->getActivate(), PDO::PARAM_STR);
    }

    /**
     *
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables()
    {
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

    public static function storeAccount($acc){
        $sql="INSERT INTO ".static::getTables()." VALUES ".static::getValues();
        $db=FDatabase::getInstance();
        $id=$db->store($sql,"FAccount",$acc);
        if($id) return $id;
        else return null;
    }

    public static function loadAccountById($id){
        $sql="SELECT * FROM ".static::getTables()." WHERE id=".$id.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $acc=new EAccount($result['id'], $result['username'],$result['password'],$result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        }
        else return null;
    }

    /**
     * Funzione ch permette la load dell'utente in base all'username
     * @param string $comune dell'user di riferimento
     * @return object $user
     */

    public static function loadAccountByUsername($username){
        $sql="SELECT * FROM ".static::getTables()." WHERE Username='".$username."';";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $acc=new EAccount($result['id'], $result['username'],$result['password'],$result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        }
        else return null;
    }


    /**
     * Funzione ch permette la load dell'utente in base al paramentro id
     * @param int $id dell'user
     * @return object $user
     */
    public static function loadAccountByEmail($email){
        $sql="SELECT * FROM ".static::getTables()." WHERE Email=".$email.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $acc=new EAccount($result['id'], $result['username'],$result['password'],$result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        }
        else return null;
    }


    public static function loadByProvincia($provincia){
        $sql="SELECT * FROM ".static::getTables()." WHERE provincia=".$provincia.";";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $acc=new EAccount($result['id'], $result['username'],$result['password'],$result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        }
        else return null;
    }

    /**
     * Funzione che permette la delete dell'utente in base all'id
     * @param int $id dell'utente che si vuole eliminare
     * @return bool
     */

    public static function deleteAccount($id){
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

    public static function UpdateAccount($id,$field,$newvalue)
    {
        $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->update($sql)) return true;
    }

    /**
     * Funzione che permette di modificare il numero di telefono
     * associato ad un certo account di un utente
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $telnum numero di telefono
     * @return bool
     */
    public static function UpdateTelNum($id, $telnum)
    {
        $field = "telnumber";
        if (FAccount::update($id, $field, $telnum)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare la descrizione
     * di un certo account associato ad un certo utente
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $description "nuova"
     * @return bool
     */

    public static function UpdateDescription($id, $description)
    {
        $field = "description";
        if (FAccount::update($id, $field, $description)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare la variabile dell'attivazione dell'account
     * associato ad un utente ( l'account deve essere attivo )
     * @param int $id dell'account che vuole effettuare la modifica
     * @param bool $activate
     * @return bool
     */
    public static function UpdateActivate($id, $activate)
    {
        $field = "activate";
        if (FAccount::update($id, $field, $activate)) return true;
        else return false;
    }


    /**
     * Funzione che verifica l'esistenza di un account con quell'username e password
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $username
     * @param string $password
     * @return object $acc
     */
    public static function ExistAccount($username, $password)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE username='" . $username . "' AND " . "password='" . $password . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) {
            $acc = new EAccount($result['username'], $result['password'],$result['email'],$result['conto'], $result['telnumber'], $result['description']);
            $acc->setId($result['id']);
            $acc->setActivate($result['activate']);
            return $acc;
        } else return null;
    }

    /**
     * Funzione che permette di verificare se esiste un account con quell'username
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $username da cercare
     * @return bool
     */

    public static function ExistUsername($username)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE username='" . $username . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) return true;
        else return false;
    }
    /** Funzione che permette di verificare se esite un account con una specifica mail
     * @param string $mail da cercare
     * @return bool
     */
    public static function ExistMail($mail)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE email='" . $mail . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto Address dai risultati dlella query.
     * @param string $row restituita dal dmbs
     * @return EAddress|obj
     */
    static function createObjectFromRow($row)
    {
        $account = new EAccount(); //costruisce l'istanza dell'oggetto
        $account->setUsername($row['username']);
        $account->setPassword($row['password']);
        $account->setEmail($row['email']);
        $account->setTelnumber($row['telnumber']);
        $account->setDescrizione($row['descrizione']);
        $account->setConto($row['conto']);
        $account->setActivate($row['activate']);

        return $account;
    }
}

?>